@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8 px-4 md:px-8 lg:px-16">
    <!-- Header Section -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">📋 Daftar Menu</h1>
        <p class="text-gray-600 text-lg">Pilih menu favorit Anda dan buat pesanan dengan cepat dan mudah!</p>
    </div>

    <!-- Error Alert jika booth_id kosong -->
    @if (!$booth_id)
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg mb-4 text-sm text-center">
            Error: Tidak ada booth yang tersedia.
        </div>
    @endif

    <!-- Filter Bagian -->
    <div class="bg-white shadow-lg rounded-lg p-4 mb-6">
        <form action="{{ route('menus.index') }}" method="GET">
            <label for="category" class="block text-sm font-semibold text-gray-600 mb-2">Filter Kategori</label>
            <div class="flex items-center gap-2">
                <select id="category" name="category"
                        class="flex-1 border border-blue-400 p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md transition duration-200">Terapkan
                </button>
            </div>
        </form>
    </div>

    <!-- Form untuk menampilkan menu dan membuat pesanan -->
    <form action="{{ route('orders.bulkCreate', ['booth_id' => $booth_id]) }}" method="POST">
        @csrf

        <!-- Grid Menu -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($menus as $menu)
            <div class="bg-white shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-200 rounded-lg p-4 flex flex-col items-center text-center border">
                <img src="{{ file_exists(public_path('storage/' . $menu->name . '.jpg')) ? asset('storage/' . $menu->name . '.jpg') : asset('images/default-menu.jpg') }}"
                     alt="{{ $menu->name }}"
                     class="w-32 h-32 object-cover rounded-md mb-3">
                <h2 class="text-gray-700 font-semibold text-sm mb-2">{{ $menu->name }}</h2>
                <p class="text-gray-500 mb-2">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                <div class="flex items-center gap-2">
                    <button type="button"
                            class="bg-blue-200 hover:bg-blue-400 text-blue-700 border px-2 py-1 rounded-md"
                            onclick="changeQuantity('qty_{{ $menu->id }}', -1)">-</button>
                    <input type="number" name="quantities[{{ $menu->id }}]" id="qty_{{ $menu->id }}"
                           class="w-12 text-center p-1 border rounded-md text-sm no-spinner" value="0" min="0">
                    <button type="button"
                            class="bg-blue-200 hover:bg-blue-400 text-blue-700 border px-2 py-1 rounded-md"
                            onclick="changeQuantity('qty_{{ $menu->id }}', 1)">+</button>
                </div>
            </div>
            @empty
                <div class="col-span-full text-center text-gray-600">Belum ada menu tersedia.</div>
            @endforelse
        </div>

        <!-- Metode Pembayaran -->
        <div class="mt-6 bg-white shadow-lg rounded-lg p-4">
            <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">Metode Pembayaran</label>
            <select name="payment_method" id="payment_method"
                    class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none">
                <option value="cash">Cash</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <!-- Catatan -->
        <div class="mt-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-md">
            <p class="text-sm">
              <strong>Catatan:</strong> 
               Jika Anda memilih metode pembayaran QRIS, harap unggah bukti pembayaran Anda di bagian konfirmasi pesanan.
               Pajak sebesar Rp 1.000 akan dikenakan untuk setiap transaksi.
           </p>
        </div>


        <!-- QRIS Image dengan tombol Unduh hanya muncul ketika dipilih -->
        <div id="qris_image_container"
             class="mt-6 hidden flex flex-col justify-center items-center bg-gray-50 border p-4 shadow-lg rounded-lg relative">

            <!-- Gambar QRIS -->
            <img src="{{ asset('images/qris.jpg') }}" alt="QRIS" class="w-52 h-52 object-cover">

            <!-- Tombol Unduh QRIS dengan ruang -->
            <button type="button"
                    onclick="downloadQrisImage()"
                    class="mt-4 bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md transition duration-200">
                Unduh QRIS
            </button>
        </div>

        <!-- Notes untuk catatan -->
<div class="mt-6 bg-white shadow-lg rounded-lg p-4">
    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
    <textarea name="notes" id="notes" rows="3" 
              class="w-full border border-gray-400 p-2 rounded-md focus:ring-2 focus:ring-blue-400 focus:outline-none"
              placeholder="Contoh: Tanpa gula, pedas, dll.">{{ old('notes') }}</textarea>
</div>


        <!-- Tombol Pesan Sekarang -->
        <div class="mt-6">
            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-lg shadow-md transition duration-200">Pesan Sekarang
            </button>
        </div>
    </form>
</div>

<!-- Tambahkan CSS untuk menghapus spinner pada input number -->
<style>
    /* Menghapus panah/spinner pada input type number di semua browser */
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield; /* Untuk Firefox */
        appearance: none;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentMethodSelect = document.getElementById('payment_method');
        const qrisImageContainer = document.getElementById('qris_image_container');

        paymentMethodSelect.addEventListener('change', function () {
            if (this.value === 'qris') {
                qrisImageContainer.classList.remove('hidden');
            } else {
                qrisImageContainer.classList.add('hidden');
            }
        });
    });

    function changeQuantity(inputId, delta) {
        const input = document.getElementById(inputId);
        const currentValue = parseInt(input.value, 10) || 0;
        const newValue = Math.max(0, currentValue + delta);
        input.value = newValue;
    }

    function downloadQrisImage() {
        const link = document.createElement('a');
        link.href = "{{ asset('images/qris.jpg') }}";
        link.download = "qris.jpg";
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
@endsection
