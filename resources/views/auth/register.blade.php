<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Eighteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-xl w-full">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Register ke <span class="text-blue-500">Eighteen</span></h1>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input id="name" type="text" name="name" required autofocus autocomplete="name" 
                       class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('name') }}">
                <p class="text-red-500 text-sm mt-2 hidden" id="name-error"></p>
            </div>

            <!-- Email Address -->
            <div class="mt-6">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" required autocomplete="username" 
                       class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('email') }}">
                <p class="text-red-500 text-sm mt-2 hidden" id="email-error"></p>
            </div>

            <!-- Kelas -->
            <div class="mt-6">
                <label for="kelas" class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <div class="flex space-x-6">
                    @foreach(['X', 'XI', 'XII'] as $kelas)
                        <label class="inline-flex items-center">
                            <input type="radio" name="kelas" value="{{ $kelas }}" 
                                   {{ old('kelas') == $kelas ? 'checked' : '' }} 
                                   class="form-radio text-blue-500 focus:ring-blue-500">
                            <span class="ml-2 text-gray-700">{{ $kelas }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="text-red-500 text-sm mt-2 hidden" id="kelas-error"></p>
            </div>

            <!-- Jurusan -->
            <div class="mt-6">
                <label for="jurusan" class="block text-sm font-medium text-gray-700 mb-2">Jurusan</label>
                <select name="jurusan" id="jurusan" 
                        class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Jurusan</option>
                    @foreach(['AKL', 'MP', 'BR', 'BD', 'ULW', 'RPL'] as $jurusan)
                        <option value="{{ $jurusan }}" 
                                {{ old('jurusan') == $jurusan ? 'selected' : '' }}>
                            {{ $jurusan }}
                        </option>
                    @endforeach
                </select>
                <p class="text-red-500 text-sm mt-2 hidden" id="jurusan-error"></p>
            </div>

            <!-- Phone -->
            <div class="mt-6">
                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">No Telepon</label>
                <input id="phone" type="text" name="phone" 
                       class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500" 
                       value="{{ old('phone') }}">
                <p class="text-red-500 text-sm mt-2 hidden" id="phone-error"></p>
            </div>

            <!-- Password -->
            <div class="mt-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" 
                       class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-red-500 text-sm mt-2 hidden" id="password-error"></p>
            </div>

            <!-- Confirm Password -->
            <div class="mt-6">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                       class="block w-full rounded-lg border-gray-300 shadow-md text-lg py-3 px-4 focus:ring-blue-500 focus:border-blue-500">
                <p class="text-red-500 text-sm mt-2 hidden" id="password_confirmation-error"></p>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('login') }}" 
                   class="text-sm text-gray-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                   Already registered?
                </a>
                <button type="submit" 
                        class="py-3 px-6 bg-blue-500 text-white rounded-lg shadow-md text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Register
                </button>
            </div>
        </form>
    </div>
</body>
</html>