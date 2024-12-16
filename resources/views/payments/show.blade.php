@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h1 class="text-2xl font-bold mb-4">Detail Pembayaran</h1>
        
        {{-- Detail Pesanan --}}
        <div class="mb-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Detail Pesanan</h3>
            <ul class="list-disc ml-5">
                @foreach ($order->orderItems as $item)
                    <li>{{ $item->menu->name }} (x{{ $item->quantity }}) - Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}</li>
                @endforeach
            </ul>
        </div>

        {{-- Total Harga --}}
        <div class="mb-4">
            <strong>Total Harga:</strong>
            <span class="text-lg font-semibold text-gray-800">
                Rp {{ number_format(
                 $order->orderItems->sum(fn($item) => $item->menu->price * $item->quantity) +
                   ($order->payment_method === 'qris' ? 1000 : 0), 
                    0, ',', '.'
               ) }}
            </span>
          @if ($order->payment_method === 'qris')
             <p class="text-sm text-gray-600">* Termasuk biaya tambahan QRIS sebesar Rp 1.000</p>
          @endif
        </div>

{{-- Catatan --}}
@if ($order->notes)
<div class="mb-4">
    <h3 class="text-lg font-semibold text-gray-700">Catatan</h3>
     <p class="font-mono text-gray-800">{{ $order->notes }}</p>
</div>
@endif

        <div class="mb-4">
            <p><strong>Status Pesanan:</strong> {{ ucfirst($order->status ?? 'Tidak Diketahui') }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ strtoupper($order->payment_method ?? 'Tidak Diketahui') }}</p>
        </div>
        
        {{-- Jika metode pembayaran QRIS --}}
        @if ($order->payment_method === 'qris')
            <div class="mb-4">
                @if ($order->status === 'waiting approval')
                    <p class="text-yellow-600">Menunggu persetujuan penjual. Silakan tunggu!</p>
                @elseif ($order->status === 'approved')
                    <p class="text-green-600">Pembayaran disetujui! Silakan cek status pesanan Anda.</p>
                @elseif ($order->status === 'rejected')
                    <p class="text-red-600">Pembayaran ditolak. Silakan upload ulang bukti pembayaran.</p>
                @else
                    {{-- Form Upload Bukti Pembayaran --}}
                    <form action="{{ route('payments.upload', $order->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="proof" class="block text-gray-700">Upload Bukti Pembayaran (QRIS):</label>
                            <input type="file" name="proof" id="proof" accept="image/*" required
                                   class="mt-2 p-2 border rounded w-full">
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                            Kirim Bukti
                        </button>
                    </form>
                @endif
            </div>
        @else
            {{-- Jika metode pembayaran Tunai --}}
            <div class="mb-4">
                <p>Pembayaran dilakukan dengan tunai. Silakan ambil pesanan Anda setelah status pesanan berubah menjadi "Selesai".</p>
            </div>
        @endif

        {{-- Link untuk melihat status pesanan --}}
        <div class="mt-6">
            <a href="{{ route('orders.status', $order->id) }}" 
               class="text-blue-600 hover:underline">
                Cek Status Pesanan
            </a>
        </div>
    </div>
</div>
@endsection
