<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Approve or reject a payment by the vendor.
     */
    public function approve(Request $request, Payment $payment)
    {
        // Pastikan hanya penjual booth terkait yang dapat mengakses
        if ($payment->order->booth->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Validasi input action (approved/rejected)
        $validated = $request->validate([
            'action' => 'required|in:approved,rejected',
        ]);

        // Update status pembayaran
        $payment->update([
            'status' => $validated['action'],
            'order_status' => $validated['action'] === 'approved' ? 'approved' : 'rejected',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('payments.show', $payment->id)
                         ->with('success', 'Pembayaran telah diproses.');
    }

    /**
     * Reject a payment.
     */
    public function reject(Payment $payment)
    {
        // Pastikan hanya penjual booth terkait yang dapat mengakses
        if ($payment->order->booth->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Update status pembayaran menjadi "rejected"
        $payment->update(['status' => 'rejected']);

        return redirect()->back()->with('error', 'Pembayaran ditolak.');
    }

    /**
     * Show payment details for a specific order.
     */
    public function show(Order $order)
    {
        // Pastikan hanya pemilik order yang dapat mengakses
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        return view('payments.show', compact('order'));
    }

    /**
     * Upload payment proof (QRIS) by the user.
     */
    public function upload(Request $request, Order $order)
{
    // Pastikan pengguna hanya mengunggah bukti pembayaran untuk pesanannya sendiri
    if ($order->user_id !== auth()->id()) {
        abort(403, 'Unauthorized');
    }

    // Validasi file bukti pembayaran
    $request->validate([
        'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Simpan file bukti pembayaran
    $proofPath = $request->file('proof')->store('payment-proofs', 'public');

    // Simpan data pembayaran
    $order->payment()->create([
        'proof_image' => $proofPath,
        'status' => 'pending',
        'method' => 'qris',
    ]);

    // Perbarui status di tabel orders
    $order->status = 'pending';
    $order->save();

    // Redirect dengan pesan sukses
    return redirect()->route('orders.status', $order->id)
                     ->with('success', 'Bukti pembayaran berhasil diunggah.');
}


public function approvePayment($payment_id)
{
    $payment = Payment::findOrFail($payment_id);
    $payment->status = 'approved'; // Ubah status pembayaran jadi approved
    $payment->save();

    // Update status pesanan jika perlu
    $order = $payment->order;
    $order->status = 'approved'; // Ubah status pesanan jadi approved (jika perlu)
    $order->save();

    return redirect()->route('orders.status', ['order' => $order->id]);
}

public function declinePayment($payment_id)
{
    $payment = Payment::findOrFail($payment_id);
    $payment->status = 'declined'; // Ubah status pembayaran jadi declined
    $payment->save();

    return redirect()->route('orders.status', ['order' => $payment->order->id]);
}

}