<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $invoices = Invoice::with('order.orderItems')
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->get()
            ->map(function ($invoice) {
                $price = 0;
                $quantity = 0;

                if ($invoice->order && $invoice->order->orderItems) {
                    $price = $invoice->order->orderItems->sum('price');
                    $quantity = $invoice->order->orderItems->sum('quantity');
                }

                return [
                    'id' => $invoice->id,
                    'number' => 'INV' . str_pad($invoice->id, 3, '0', STR_PAD_LEFT),
                    'date' => $invoice->created_at->format('Y-m-d h:i:s A'),
                    'quantity' => $quantity,
                    'price' => $price,
                    'status' => $invoice->order->status ?? 'Unknown',
                ];
            });

        return response()->json($invoices);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
