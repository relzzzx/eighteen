@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Pembayaran QRIS</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Pesanan Anda - Booth: {{ $order->booth->name }}</h2>

        @if ($order->payment && $order->payment->status != 'pending')
            <p class="text-gray-500 mb-4">
                <strong>Status Pembayaran:</strong> 
                @if ($order->payment->status == 'approved')
                    <span class="text-green-500">Pembayaran Disetujui</span>
                @elseif ($order->payment->status == 'declined')
                    <span class="text-red-500">Pembayaran Ditolak</span>
                @endif
            </p>
        @else
            <p class="text-gray-500 mb-4">Silakan unggah bukti pembayaran QRIS untuk melanjutkan pemesanan Anda.</p>

            <form action="{{ route('payment.create', ['order' => $order->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="proof_image" class="block text-sm font-medium text-gray-700">Bukti Pembayaran (QRIS)</label>
                    <input type="file" name="proof_image" id="proof_image" class="mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                </div>

                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Kirim Bukti Pembayaran</button>
            </form>
        @endif
    </div>
</div>
@endsection