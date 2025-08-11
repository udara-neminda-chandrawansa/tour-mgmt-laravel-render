<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Enquiry;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    // get all payments (for table)
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Payment::query()
            ->with(['quotation.itinerary.enquiry']);

        // Restrict agents to their assigned enquiries
        if ($user->role === 'agent') {
            $assignedEnquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id');
            $query->whereHas('quotation.itinerary', function ($q) use ($assignedEnquiryIds) {
                $q->whereIn('enquiry_id', $assignedEnquiryIds);
            });
        }

        // Filters
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('assigned_to')) {
            $assignedEnquiryIds = Enquiry::where('assigned_to', $request->assigned_to)->pluck('id');
            $query->whereHas('quotation.itinerary', function ($q) use ($assignedEnquiryIds) {
                $q->whereIn('enquiry_id', $assignedEnquiryIds);
            });
        }

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('created_at', [$request->from, $request->to]);
        }

        Log::info('Payments filtered/loaded', ['data' => $request->all()]);

        return response()->json($query->paginate(10));
    }

    // create payments
    public function store(Request $request)
    {
        $request->validate([
            'quotation_id' => 'required|exists:quotations,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|string',
            'transaction_reference' => 'nullable|string',
        ]);

        $user = Auth::user();
        $quotation = Quotation::with('itinerary.enquiry')->findOrFail($request->quotation_id);

        // Restrict agents to their assigned enquiries
        if ($user->role === 'agent') {
            $assignedEnquiryIds = Enquiry::where('assigned_to', $user->id)->pluck('id')->toArray();
            if (!in_array($quotation->itinerary->enquiry_id, $assignedEnquiryIds)) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
        }

        $payment = Payment::create($request->only([
            'quotation_id',
            'amount',
            'payment_method',
            'transaction_reference',
        ]));

        Log::info('New payment submitted', ['data' => $request->all()]);

        return response()->json(['message' => 'Payment Saved Successfuly', 'data' => $payment], 201);
    }
}
