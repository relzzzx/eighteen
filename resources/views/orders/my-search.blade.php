@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Cari Pesanan Saya</h1>

    {{-- Form Pencarian --}}
    <form action="{{ route('orders.my-search') }}" method="GET" class="mb-4">
        <div class="flex flex-col md:flex-row gap-4">
            <div>
                <label for="order_id" class="block text-gray-700">Nomor Pesanan:</label>
                <input type="text" name="order_id" id="order_id" value="{{ request('order_id') }}"
                       class="border rounded w-full p-2">
            </div>

            <div>
                <label for="status" class="block text-gray-700">Status Pesanan:</label>
                <select name="status" id="status" class="border rounded w-full p-2">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            <div>
                <label for="booth_name" class="block text-gray-700">Nama Booth:</label>
                <input type="text" name="booth_name" id="booth_name" value="{{ request('booth_name') }}"
                       class="border rounded w-full p-2">
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Cari
            </button>
        </div>
    </form>

    {{-- Hasil Pencarian --}}
    @if ($orders->isNotEmpty())
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Nomor Pesanan</th>
                    <th class="border px-4 py-2">Nama Booth</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Total</th>
                    <th class="border px-4 py-2">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="border px-4 py-2">{{ $order->id }}</td>
                        <td class="border px-4 py-2">{{ $order->booth->name ?? 'Tidak Diketahui' }}</td>
                        <td class="border px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="border px-4 py-2">Rp {{ number_format($order->orderItems->sum(fn($item) => $item->menu->price * $item->quantity), 0, ',', '.') }}</td>
                        <td class="border px-4 py-2">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    @else
        <p class="text-red-500">Tidak ada pesanan yang ditemukan.</p>
    @endif
</div>
@endsection