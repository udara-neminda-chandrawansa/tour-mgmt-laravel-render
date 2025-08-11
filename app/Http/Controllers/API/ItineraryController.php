<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItineraryDay;
use App\Models\Itinerary;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ItineraryController extends Controller
{
    // get all itineraries (for the table - w pagination)
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Itinerary::with(['days', 'enquiry']);

        // If agent, only show assigned itineraries
        if ($user->role === 'agent') {
            // Get all enquiry IDs assigned to this agent
            $enquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id');

            // Filter itineraries by those enquiry IDs
            $query->whereIn('enquiry_id', $enquiryIds);
        }

        // paginate
        $itineraries = $query->paginate(10);

        Log::info('Itineraries loaded', ['data' => $request->all()]);

        return response()->json($itineraries);
    }

    // get specific itinerary by id
    public function show($id)
    {
        $user = Auth::user();

        $itinerary = Itinerary::with(['days', 'enquiry'])->findOrFail($id);

        $enquiry = Enquiry::findOrFail($itinerary->enquiry_id);

        if ($user->role === 'agent') {
            if ($enquiry->assigned_to !== Auth::id()) {
                return response()->json(['message' => 'Itinerary fetching failed: You are not authorized to view this itinerary'], 403);
            }
        }

        Log::info('Itinerary searched by agent/admin by ID', ['data' => $itinerary]);

        return response()->json($itinerary);
    }

    // create itinerary
    public function store(Request $request)
    {
        $request->validate([
            'enquiry_id' => 'required|exists:enquiries,id',
            'title' => 'required|string|max:255',
            'notes' => 'nullable|string',
            'days' => 'required|array|min:1',
            'days.*.day' => 'required|integer|min:1',
            'days.*.location' => 'required|string|max:255',
            'days.*.activities' => 'required|array|min:1',
            'days.*.activities.*' => 'required|string|max:255',
        ]);

        // Check if agent is assigned to this enquiry
        $enquiry = Enquiry::findOrFail($request->enquiry_id);

        if ($enquiry->assigned_to !== Auth::id()) {
            return response()->json([
                'message' => 'Itinerary creation failed: You are not authorized to create an itinerary for this enquiry.',
            ], 403);
        }

        // Ensure days are sequential starting from 1
        $dayNumbers = array_column($request->days, 'day');
        sort($dayNumbers);
        $expected = range(1, count($dayNumbers));
        if ($dayNumbers !== $expected) {
            return response()->json([
                'message' => 'Itinerary creation failed: Days are not sequential.',
            ], 422);
        }

        // Create itinerary
        $itinerary = Itinerary::create([
            'enquiry_id' => $request->enquiry_id,
            'title' => $request->title,
            'notes' => $request->notes
        ]);

        // Create days
        foreach ($request->days as $day) {
            ItineraryDay::create([
                'itinerary_id' => $itinerary->id,
                'day' => $day['day'],
                'location' => $day['location'],
                'activities' => $day['activities']
            ]);
        }

        Log::info('New itinerary submitted', ['data' => $request->all()]);

        return response()->json([
            'message' => 'Itinerary created successfully.',
            'data' => $itinerary->load('days')
        ], 201);
    }

    // update specific itinerary
    public function update(Request $request, $id)
    {
        $itinerary = Itinerary::findOrFail($id);
        $enquiry = Enquiry::findOrFail($itinerary->enquiry_id);

        if ($enquiry->assigned_to !== Auth::id()) {
            return response()->json(['message' => 'Itinerary updating failed: You are not authorized to update this itinerary'], 403);
        }

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'notes' => 'nullable|string',
            'days' => 'sometimes|required|array|min:1',
            'days.*.day' => 'required_with:days|integer|min:1',
            'days.*.location' => 'required_with:days|string|max:255',
            'days.*.activities' => 'required_with:days|array|min:1',
            'days.*.activities.*' => 'required|string|max:255',
        ]);

        // sequential day check
        if (isset($validated['days'])) {
            $dayNumbers = collect($validated['days'])->pluck('day')->all();
            $expected = range(1, count($dayNumbers));
            if ($dayNumbers !== $expected) {
                return response()->json([
                    'message' => 'Itinerary updating failed: Days are not sequential.',
                ], 422);
            }
        }

        // Update itinerary fields
        $itinerary->update([
            'title' => $validated['title'] ?? $itinerary->title,
            'notes' => $validated['notes'] ?? $itinerary->notes,
        ]);

        // Update days if provided
        if (isset($validated['days'])) {
            // Delete old days
            $itinerary->days()->delete();

            // Create new days
            foreach ($validated['days'] as $day) {
                $itinerary->days()->create([
                    'day' => $day['day'],
                    'location' => $day['location'],
                    'activities' => $day['activities'],
                ]);
            }
        }

        Log::info('Itinerary updated', ['data' => $request->all()]);

        return response()->json([
            'message' => 'Itinerary updated successfully',
            'data' => $itinerary->load('days')
        ]);
    }

    // soft delete specific itinerary
    public function destroy($id)
    {
        $itinerary = Itinerary::findOrFail($id);

        $enquiry = Enquiry::findOrFail($itinerary->enquiry_id);

        $user = Auth::user();

        if ($user->role === 'agent') {
            if ($enquiry->assigned_to !== Auth::id()) {
                return response()->json(['message' => 'Itinerary deleting failed: You are not authorized to delete this itinerary'], 403);
            }
        }

        $attributes = $itinerary->toArray();

        $itinerary->delete();

        Log::info('Itinerary deleted', ['data' => $attributes]);

        return response()->json(['message' => 'Itinerary deleted successfully']);
    }
}
