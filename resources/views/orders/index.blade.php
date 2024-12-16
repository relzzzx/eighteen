@extends('layouts.app')

<head>
    <!-- Meta tags dan resource lainnya -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Orders</title>
</head>

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-8">Pesanan Saya</h1>

    @if ($orders->isEmpty())
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">Tidak ada pesanan yang ditemukan.</p>
            <a href="{{ route('menus.index') }}" 
               class="mt-4 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition">
                Mulai Pesan Sekarang
            </a>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 bg-white rounded-lg shadow-lg overflow-hidden">
                <thead>
                    <tr class="bg-blue-500 text-left text-sm uppercase text-white">
                        <th class="px-6 py-3 border-b border-gray-200">Nomor Pesanan</th>
                        <th class="px-6 py-3 border-b border-gray-200">Metode Pembayaran</th>
                        <th class="px-6 py-3 border-b border-gray-200">Booth</th>
                        <th class="px-6 py-3 border-b border-gray-200">Menu</th>
                        <th class="px-6 py-3 border-b border-gray-200">Jumlah</th>
                        <th class="px-6 py-3 border-b border-gray-200">Harga</th>
                        <th class="px-6 py-3 border-b border-gray-200">Pajak</th>
                        <th class="px-6 py-3 border-b border-gray-200">Tanggal</th>
                        <th class="px-6 py-3 border-b border-gray-200">Status</th>
                        <th class="px-6 py-3 border-b border-gray-200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        @php
                            $rowspan = $order->orderItems->count(); // Menghitung jumlah item untuk rowspan
                        @endphp
                        @foreach ($order->orderItems as $index => $orderItem)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-gray-50' }} hover:bg-gray-100 transition">
                                <!-- Nomor Pesanan hanya muncul di baris pertama -->
                                @if ($index === 0)
                                    <td rowspan="{{ $rowspan }}" class="px-6 py-4 border-b border-gray-200 text-gray-800">{{ $order->id }}</td>
                                    <td rowspan="{{ $rowspan }}" class="px-6 py-4 border-b border-gray-200 text-gray-800">
                                        {{ $order->payment_method === 'qris' ? 'QRIS' : 'Tunai' }}
                                    </td>
                                @endif

                                <!-- Booth, Menu, Jumlah, Harga, Pajak -->
                                <td class="px-6 py-4 border-b border-gray-200 text-gray-800">{{ $orderItem->booth->name }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-gray-800">{{ $orderItem->menu->name }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-gray-800">{{ $orderItem->quantity }}</td>
                                <td class="px-6 py-4 border-b border-gray-200 text-gray-800">
                                    Rp {{ number_format($orderItem->menu->price * $orderItem->quantity, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-200 text-gray-800">
                                    @php
                                        $tax = ($order->payment_method === 'qris') ? 1000 : 0;
                                    @endphp
                                    Rp {{ number_format($tax, 0) }}
                                </td>
                                
                                <!-- Tanggal, Status, Aksi hanya muncul di baris pertama -->
                                @if ($index === 0)
                                    <td rowspan="{{ $rowspan }}" class="px-6 py-4 border-b border-gray-200 text-gray-800">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
                                    <td rowspan="{{ $rowspan }}" class="px-6 py-4 border-b border-gray-200">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                       {{ $order->status === 'completed' ? 'bg-blue-100 text-blue-600' : 
                                        ($order->status === 'approved' ? 'bg-green-100 text-green-600' : 
                                           ($order->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : 
                                              'bg-red-100 text-red-600')) }}">
                                                 {{ ucfirst($order->status) }}
                                    </span>
                                    </td>
                                    <td rowspan="{{ $rowspan }}" class="px-6 py-4 border-b border-gray-200">
                                        <a href="{{ route('orders.status', $order->id) }}" 
                                           class="text-blue-500 hover:text-blue-600 hover:underline">
                                            Detail
                                        </a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach

                        <!-- Pemisah antar pesanan -->
                        <tr>
                            <td colspan="10" class="bg-gray-200 h-2"></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
