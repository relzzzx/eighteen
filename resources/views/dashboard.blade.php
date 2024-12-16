@extends('layouts.app')

<head>
    <!-- Meta tags dan resource lainnya -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Eighteen</title>
</head>

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow-lg rounded-lg">
                <!-- Hero Section -->
                <div class="relative rounded-t-lg text-white">
                    <!-- Background Image -->
                    <img src="storage/images/about.jpg" alt="Background" class="absolute inset-0 w-full h-full object-cover opacity-70">
                    
                    <!-- Overlay for Tint -->
                    <div class="absolute inset-0 bg-blue-800 opacity-30"></div>
                    
                    <!-- Content -->
                    <div class="relative p-8 text-center">
                        <h1 class="text-4xl font-extrabold mb-2">Selamat Datang di Eighteen</h1>
                        <p class="text-lg mb-6">Platform pemesanan kantin online yang memudahkan aktivitas sekolah Anda.</p>
                        <a href="{{ route('menus.index') }}"
                           class="inline-block px-8 py-3 bg-white text-blue-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition duration-300">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>                

                <!-- Tentang Section -->
                <div class="p-8 bg-gray-50">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tentang Eighteen</h2>
                    <p class="text-gray-700 leading-6 mb-6">
                        Eighteen adalah platform pemesanan kantin online yang dirancang khusus untuk membantu siswa dan guru
                        memesan makanan tanpa perlu mengantri. Dengan berbagai booth yang tersedia, pembayaran yang fleksibel,
                        dan pengalaman pemesanan yang cepat, kami hadir untuk mendukung kenyamanan Anda setiap hari di sekolah.
                    </p>
                </div>

                <!-- Features Section -->
                <div class="p-8 bg-white">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-4">Fitur Kami</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-700">Tanpa Antri</h4>
                                <p class="text-sm text-gray-600">Pesan makanan langsung dari aplikasi.</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-3-3v6m-6 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-700">Beragam Booth</h4>
                                <p class="text-sm text-gray-600">Pilih makanan favorit Anda dengan mudah.</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2a4 4 0 00-1 7.874V20a1 1 0 001 1h10a1 1 0 001-1v-3.126A4 4 0 0017 9z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-700">Pembayaran QRIS</h4>
                                <p class="text-sm text-gray-600">Fleksibel menggunakan cash atau QRIS.</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="w-10 h-10 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l2 2m0-2l-2 2m9-2l2 2m0-2l-2 2m-6 0a8 8 0 100-16 8 8 0 000 16z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-700">UI Intuitif</h4>
                                <p class="text-sm text-gray-600">Mudah digunakan oleh siapa saja.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
