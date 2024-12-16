@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Persetujuan Pembayaran</h1>
        
        <div class="mb-4">
            <p><strong>Nama Booth:</strong> {{ $order->booth->name }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method) }}</p>
            <p><strong>Bukti Pembayaran:</strong></p>
            <img src="{{ asset('storage/' . $order->proof) }}" alt="Bukti Pembayaran" class="w-full max-w-md mb-4">
        </div>

        @if ($order->proof_status === 'waiting')
            <form action="{{ route('payments.approve', $order->id) }}" method="POST">
                @csrf
                <button type="submit" name="action" value="approved" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Setujui Pembayaran
                </button>
                <button type="submit" name="action" value="rejected" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 ml-4">
                    Tolak Pembayaran
                </button>
            </form>
        @else
            <p class="text-yellow-600 mt-4">Pembayaran sudah diproses: {{ ucfirst($order->proof_status) }}</p>
        @endif
    </div>
</div>
@endsection