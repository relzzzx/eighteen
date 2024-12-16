@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-8">
    <!-- Header -->
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">📦 Daftar Pesanan</h1>

    <!-- Tabel Pesanan -->
    <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
        <table class="min-w-full divide-y divide-gray-200 table-auto">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="py-4 px-6 text-left">#</th>
                    <th class="py-4 px-6 text-left">Pembeli</th>
                    <th class="py-4 px-6 text-left">Pesanan</th>
                    <th class="py-4 px-6 text-left">Metode Pembayaran</th>
                    <th class="py-4 px-6 text-left">Subtotal</th>
                    <th class="py-4 px-6 text-left">Tax</th>
                    <th class="py-4 px-6 text-left">Total Harga</th>
                    <th class="py-4 px-6 text-left">Status</th>
                    <th class="py-4 px-6 text-left">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($orders as $order)
                <tr class="hover:bg-gray-50 transition-all duration-200">
                    <!-- ID Pesanan -->
                    <td class="py-4 px-6 text-sm text-gray-700">{{ $order->id }}</td>
                    
                    <!-- Nama Pembeli -->
                    <td class="py-4 px-6 text-sm text-gray-700 font-semibold">{{ $order->user->name }}</td>
                    
                    <!-- Menu yang Dipesan -->
                    <td class="py-4 px-6 text-sm text-gray-700">
                        <ul class="list-disc ml-4">
                            @foreach ($order->orderItems as $item)
                            <li>{{ $item->menu->name }} (x{{ $item->quantity }})</li>
                            @endforeach
                        </ul>
                    </td>
                    
                    <!-- Metode Pembayaran -->
                    <td class="py-4 px-6 text-sm text-gray-700 capitalize">{{ $order->payment_method }}</td>
                    
                    <!-- Subtotal -->
                    <td class="py-4 px-6 text-sm text-gray-700">
                        Rp {{ number_format($order->orderItems->sum(fn($item) => $item->quantity * $item->menu->price), 0, ',', '.') }}
                    </td>

                    <!-- Tax -->
                    <td class="py-4 px-6 text-sm text-gray-700">
                        Rp {{ number_format($order->tax, 0, ',', '.') }}
                    </td>
                    
                    <!-- Total Harga -->
                    <td class="py-4 px-6 text-sm text-gray-700 font-bold">
                        Rp {{ number_format($order->orderItems->sum(fn($item) => $item->quantity * $item->menu->price) + $order->tax, 0, ',', '.') }}
                    </td>
                    
                    <!-- Status -->
<td class="py-4 px-6 text-sm font-semibold 
    {{ $order->status === 'completed' ? 'text-blue-600' : 
       ($order->status === 'declined' ? 'text-red-600' : 
       ($order->status === 'approved' ? 'text-green-600' : 'text-yellow-500')) }}">
    {{ ucfirst($order->status) }}
</td>

                    
                    <!-- Tombol Aksi -->
                    <td class="py-4 px-6 flex space-x-2">
                        <a href="{{ route('orders.status', $order->id) }}" 
                           class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded-md shadow-md text-center">Detail</a>
                        @if ($order->status === 'pending')
                        <form action="{{ route('admin.orders.approve', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded-md shadow-md">Setujui</button>
                        </form>
                        <form action="{{ route('admin.orders.decline', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded-md shadow-md">Tolak</button>
                        </form>
                        @elseif ($order->status === 'approved')
                        <form action="{{ route('admin.orders.complete', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded-md shadow-md">Selesaikan</button>
                        </form>
                        @else
                        <span class="text-gray-400 text-sm">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <!-- Jika Tidak Ada Pesanan -->
                <tr>
                    <td colspan="9" class="py-8 text-center text-gray-500">
                        Tidak ada pesanan yang tersedia.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
