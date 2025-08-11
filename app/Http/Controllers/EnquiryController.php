<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Log;

class EnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Enquiry::query();

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        // Filter by assigned_to (user id)
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }

        // Filter by travel date range
        if ($request->has('from') && $request->has('to')) {
            $query->whereBetween('travel_start_date', [$request->from, $request->to]);
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        $enquiries = $query->latest()->paginate(10);

        Log::info('Enquiries filtered/loaded', ['data' => $request->all()]);

        return response()->json($enquiries);
    }

    public function store(Request $request)
    {
        $today = now()->toDateString();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'travel_start_date' => "required|date|after:$today",
            'travel_end_date' => "required|date|after:travel_start_date",
            'number_of_people' => 'required|integer|min:1',
            'preferred_destinations' => 'required|array|min:1',
            'preferred_destinations.*' => 'string|max:255',
            'budget' => 'required|numeric|min:1',
        ]);

        $validated['status'] = 'pending';

        $enquiry = Enquiry::create($validated);

        Log::info('New enquiry submitted', ['data' => $request->all()]);

        return redirect()->back()->with('success', 'Enquiry submitted successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in-progress,converted,rejected',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->status = $request->status;
        $enquiry->save();

        Log::info('Enquiry status updated', ['data' => $request->all()]);

        return response()->json(['success' => true]);
    }

    public function assignAgent(Request $request, $id)
    {
        $request->validate([
            'agent_id' => 'required|exists:users,id',
        ]);

        $enquiry = Enquiry::findOrFail($id);
        $enquiry->assigned_to = $request->agent_id;
        $enquiry->save();

        Log::info('Agent assigned to enquiry', ['data' => $request->all()]);

        return response()->json(['success' => true]);
    }
}
