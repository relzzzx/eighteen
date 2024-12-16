@extends('layouts.app')

@section('content')
<div class="container mx-auto my-10 px-6 max-w-7xl">
    <!-- Header Section -->
    <h1 class="text-3xl font-bold text-center text-blue-600 mb-6">📦 Pesanan untuk Booth Anda 📦</h1>
    
    @if ($orders->isEmpty())
        <!-- Alert jika tidak ada pesanan -->
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-lg shadow-sm text-center">
            🤷‍♂️ Tidak ada pesanan untuk booth Anda saat ini.
        </div>
    @else
        <!-- Table Section -->
        <div class="overflow-x-auto bg-white rounded-lg shadow-md border p-6">
    <table class="table-auto w-full border-collapse text-sm">
        <thead class="bg-blue-100 text-blue-700">
            <tr>
                <th class="px-4 py-2 border text-center">Nomor Pesanan</th>
                <th class="px-4 py-2 border text-center">Nama Pembeli</th>
                <th class="px-4 py-2 border text-center">Metode Pembayaran</th>
                <th class="px-4 py-2 border text-center">Menu</th>
                <th class="px-4 py-2 border text-center">Jumlah</th>
                <th class="px-4 py-2 border text-center">Harga</th>
                <th class="px-4 py-2 border text-center">Pajak</th>
                <th class="px-4 py-2 border text-center">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPrice = 0;
                $totalTax = 0;
            @endphp
            @foreach ($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center">{{ $order->id }}</td> <!-- Nomor Pesanan center -->
                <td class="px-4 py-2 border text-center">{{ $order->user->name }}</td> <!-- Nama Pembeli Paling Kiri -->
                <td class="px-4 py-2 border text-center">{{ $order->payment_method === 'qris' ? 'QRIS' : 'Tunai' }}</td> <!-- Metode Pembayaran -->
                <td class="px-4 py-2 border">
                    <ul class="space-y-2">
                        @foreach ($order->items as $item)
                            @if ($item->booth_id === $boothId)
                                <li>{{ $item->menu->name }} x {{ $item->quantity }}</li>
                            @endif
                        @endforeach
                    </ul>
                </td>
                <td class="px-4 py-2 border text-center">{{ $order->items->where('booth_id', $boothId)->sum('quantity') }}</td>
                <td class="px-4 py-2 border text-center">
                    Rp {{ number_format($order->items->where('booth_id', $boothId)->sum(function ($item) { return $item->menu->price * $item->quantity; }), 0) }}
                </td>
                <td class="px-4 py-2 border text-center">
                    @php
                        $tax = ($order->payment_method === 'qris') ? 1000 : 0;
                        $totalTax += $tax;
                    @endphp
                    Rp {{ number_format($tax, 0) }}
                </td>
                <td class="px-4 py-2 border text-center">{{ $order->created_at->format('Y-m-d H:i:s') }}</td>
            </tr>

            @php
                // Menambahkan harga item ke total harga (tanpa pajak)
                $orderTotalPrice = $order->items->where('booth_id', $boothId)->sum(function ($item) { return $item->menu->price * $item->quantity; });
                $totalPrice += $orderTotalPrice; // Hanya menambahkan harga menu
            @endphp
            @endforeach
        </tbody>
    </table>
</div>



        <!-- Total Harga dan Pajak -->
        <div class="mt-6 p-6 bg-gray-100 rounded-lg shadow-md">
            <div class="flex justify-between mb-4">
                <div class="text-xl font-semibold text-blue-600">Total Pendapatan Bersih:</div>
                <div class="text-xl font-semibold">Rp {{ number_format($totalPrice, 0) }}</div>
            </div>
            <div class="flex justify-between mb-4">
                <div class="text-xl font-semibold text-blue-600">Total Pajak:</div>
                <div class="text-xl font-semibold">Rp {{ number_format($totalTax, 0) }}</div>
            </div>
            <div class="flex justify-between text-lg font-semibold text-blue-800">
                <div>Total Pendapatan Kotor:</div>
                <div>Rp {{ number_format($totalPrice + $totalTax, 0) }}</div>
            </div>
        </div>

    @endif
</div>
@endsection
