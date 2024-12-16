@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header Section -->
    <h1 class="text-4xl font-extrabold text-center text-gray-800 mb-10">💰 Pendapatan Penjual dan Pajak 💰</h1>

    <!-- Total Pendapatan Kotor dan Pajak Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <!-- Total Pendapatan Kotor -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 text-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-medium uppercase mb-2">Total Pendapatan Kotor</h2>
            <p class="text-4xl font-bold">
                Rp {{ number_format($totalGrossRevenue, 0, ',', '.') }}
            </p>
            <p class="text-sm mt-2">Termasuk total pendapatan bersih dan pajak admin</p>
        </div>
        <!-- Total Pajak -->
        <div class="bg-gradient-to-r from-red-400 to-pink-500 text-white rounded-lg shadow-lg p-6">
            <h2 class="text-lg font-medium uppercase mb-2">Total Pajak (Pendapatan Admin)</h2>
            <p class="text-4xl font-bold">
                Rp {{ number_format($totalTax, 0, ',', '.') }}
            </p>
            <p class="text-sm mt-2">Pendapatan admin dari setiap transaksi QRIS</p>
        </div>
    </div>

    @if (empty($boothRevenues))
        <!-- No Data Section -->
        <div class="text-center py-16">
            <p class="text-gray-500 text-lg">⚠️ Tidak ada data pendapatan yang ditemukan. ⚠️</p>
        </div>
    @else
        <!-- Tabel Pendapatan Penjual -->
        <div class="overflow-hidden border rounded-lg shadow-lg">
            <table class="min-w-full table-auto bg-white text-gray-800">
                <!-- Header Tabel -->
                <thead>
                    <tr class="bg-gradient-to-r from-blue-500 to-blue-700 text-white text-sm uppercase text-left">
                        <th class="px-6 py-3">ID Booth</th>
                        <th class="px-6 py-3">Nama Penjual</th>
                        <th class="px-6 py-3">Total Pendapatan Bersih</th>
                    </tr>
                </thead>
                <!-- Body Tabel -->
                <tbody>
                    @foreach ($boothRevenues as $boothId => $revenue)
                        <tr class="hover:bg-blue-50 transition-all duration-200">
                            <td class="px-6 py-4 border-b">{{ $boothId }}</td>
                            <td class="px-6 py-4 border-b">{{ $revenue['booth_name'] }}</td>
                            <td class="px-6 py-4 border-b font-semibold">
                                Rp {{ number_format($revenue['total_revenue'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
