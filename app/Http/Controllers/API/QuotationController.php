<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ItineraryDay;
use App\Models\Itinerary;
use App\Models\Enquiry;
use App\Models\Quotation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class QuotationController extends Controller
{
    // create quotation
    public function store(Request $request)
    {
        $validated = $request->validate([
            'itinerary_id' => 'required|exists:itineraries,id',
            'title' => 'required|string|max:255',
            'price_per_person' => 'required|numeric|min:0.01',
            'currency' => 'required|string|max:10',
            'notes' => 'nullable|string',
            'is_final' => 'required|boolean',
        ]);

        $user = Auth::user();
        $itinerary = Itinerary::findOrFail($validated['itinerary_id']);

        // If user is an agent, check they are assigned to the enquiry linked to this itinerary
        if ($user->role === 'agent') {
            $assignedEnquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id')->toArray();

            if (!in_array($itinerary->enquiry_id, $assignedEnquiryIds)) {
                return response()->json([
                    'message' => 'Unauthorized: You are not assigned to this itinerary\'s enquiry.'
                ], 403);
            }
        }

        // Create quotation with UUID
        $quotation = Quotation::create([
            'uniqueId' => (string) Str::uuid(), // UUID
            'itinerary_id' => $validated['itinerary_id'],
            'title' => $validated['title'],
            'price_per_person' => $validated['price_per_person'],
            'currency' => $validated['currency'],
            'notes' => $validated['notes'] ?? null,
            'is_final' => $validated['is_final'],
        ]);

        Log::info('New quotation submitted', ['data' => $request->all()]);

        return response()->json([
            'message' => 'Quotation created successfully.',
            'data' => $quotation
        ], 201);
    }

    // get all quotations (for agent/admin only)
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $quotations = Quotation::all();
        } elseif ($user->role === 'agent') {
            // Get enquiries assigned to this agent
            $assignedEnquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id');

            // Get quotations where the itinerary's enquiry_id is in those assigned enquiries
            $quotations = Quotation::whereHas('itinerary', function ($query) use ($assignedEnquiryIds) {
                $query->whereIn('enquiry_id', $assignedEnquiryIds);
            })->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        Log::info('Quotation loaded');

        return response()->json($quotations);
    }

    // get specific quotation by id (for agent/admin only)
    public function show($id)
    {
        $quotation = Quotation::findOrFail($id);
        $user = Auth::user();

        if ($user->role === 'admin') {
            return response()->json($quotation);
        }

        if ($user->role === 'agent') {
            $assignedEnquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id');

            if (in_array($quotation->itinerary->enquiry_id, $assignedEnquiryIds->toArray())) {
                return response()->json($quotation);
            }
        }

        Log::info('Quotation searched by agent/admin by ID', ['data' => $quotation]);

        return response()->json(['message' => 'Unauthorized'], 403);
    }

    // for public access (uuid)
    public function publicShow($uniqueId)
    {
        $quotation = Quotation::where('uniqueId', $uniqueId)->firstOrFail();

        Log::info('Quotation searched in public interface by UUID', ['data' => $quotation]);

        return response()->json($quotation);
    }
}
