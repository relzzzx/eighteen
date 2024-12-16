@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Edit Password</h1>

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
            <input
                type="text"
                id="name"
                value="{{ $user->name }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed focus:ring-0 focus:border-gray-300 sm:text-sm"
                readonly
            >
        </div>

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input
                type="email"
                id="email"
                value="{{ $user->email }}"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm bg-gray-100 cursor-not-allowed focus:ring-0 focus:border-gray-300 sm:text-sm"
                readonly
            >
        </div>

        <!-- Password Lama -->
        <div class="mb-4">
            <label for="current_password" class="block text-sm font-medium text-gray-700">Password Lama</label>
            <input
                type="password"
                name="current_password"
                id="current_password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                required
            >
            @error('current_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Baru -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password Baru</label>
            <input
                type="password"
                name="password"
                id="password"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
            @error('password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <!-- Konfirmasi Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >
        </div>

        <button
            type="submit"
            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600"
        >
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
