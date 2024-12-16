@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Pesanan</h1>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Pesanan Menunggu Konfirmasi</h2>

        @foreach($orders as $order)
            <div class="border-b py-4">
                <h3 class="text-lg font-bold">Order ID #{{ $order->id }}</h3>
                <p class="text-lg font-semibold">Pembeli: <strong>{{ $order->user->name }}</strong></p>
                <p class="text-gray-600">Metode Pembayaran: {{ ucfirst($order->payment_method) }}</p>
                <p class="text-gray-600">Status Pesanan: {{ ucfirst($order->status) }}</p>

                {{-- Tombol Detail Pesanan --}}
                <div class="mt-4">
                    <a href="{{ route('orders.status', ['order' => $order->id]) }}"
                       class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900">
                       Detail Pesanan
                    </a>
                </div>
                
                {{-- Tombol untuk approve atau decline pembayaran QRIS --}}
                @if($order->payment_method == 'qris' && $order->payment && $order->payment->status == 'pending')
                    <div class="mt-4">
                        <form action="{{ route('payments.approve', ['payment' => $order->payment->id]) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded">Approve Pembayaran</button>
                        </form>
                        <form action="{{ route('payments.decline', ['payment' => $order->payment->id]) }}" method="POST" class="inline-block ml-2">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">Decline Pembayaran</button>
                        </form>
                    </div>
                @endif

                {{-- Tombol untuk menandai pesanan selesai jika sudah approved --}}
                @if($order->status == 'approved')
                    <div class="mt-4">
                        <form action="{{ route('orders.complete', ['order' => $order->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Pesanan Selesai</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
@endsection
