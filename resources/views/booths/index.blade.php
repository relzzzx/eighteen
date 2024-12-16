@extends('layouts.app')

<head>
    <!-- Meta tags dan resource lainnya -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <title>Daftar Booth</title>
</head>

@section('content')

<div class="container mx-auto py-8" style="padding-left: 10rem; padding-right: 10rem;">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Daftar Booth</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach ($booths as $booth)
            <a href="{{ $booth->status !== 'closed' ? route('menus.index', ['booth_id' => $booth->id]) : '#' }}" 
               class="block rounded-lg shadow-lg overflow-hidden 
                      {{ $booth->status === 'closed' ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-white hover:shadow-xl hover:scale-105 transition-transform duration-300' }}"
               {{ $booth->status === 'closed' ? 'aria-disabled=true' : '' }}>
                {{-- Foto Booth --}}
                <img src="{{ asset('storage/images/' . \Illuminate\Support\Str::slug($booth->name) . '.jpg') }}" 
                     alt="Foto {{ $booth->name }}" class="w-full h-48 object-cover">

                {{-- Konten Booth --}}
                <div class="p-4">
                    <h2 class="text-lg font-semibold text-gray-800 truncate">{{ $booth->name }}</h2>
                    <p class="text-sm text-gray-600 mt-2 truncate">{{ $booth->description }}</p>
                    @if ($booth->status === 'closed')
                        <p class="text-sm text-red-500 mt-2 italic">Booth ini tutup</p>
                    @endif

                    <br><br><br>

                    @if (auth()->user()->role == 'penjual' && auth()->user()->id === $booth->user_id)
                        <form action="{{ route('booths.toggle-status', $booth) }}" method="POST" class="mt-2">
                            @csrf
                            @method('PATCH')
                            <button 
                                type="submit" 
                                class="px-4 py-2 rounded-lg text-white {{ $booth->status === 'open' ? 'bg-red-500 hover:bg-red-600' : 'bg-green-500 hover:bg-green-600' }}">
                                {{ $booth->status === 'open' ? 'Tutup Booth' : 'Buka Booth' }}
                            </button>
                        </form>
                    @endif
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
