<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eighteen</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-6 max-w-sm w-full">
        <h1 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Selamat Datang ke <span class="text-blue-500">Eighteen</span></h1>
        <p class="text-gray-600 text-center mb-8">Pilih salah satu opsi dibawah untuk memulai:</p>
        <div class="space-y-4">
            <a href="{{ route('login') }}" 
               class="flex items-center justify-center w-full py-3 px-4 bg-blue-500 text-white rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a7 7 0 100 14 7 7 0 000-14zm3.707 7.293a1 1 0 00-1.414 0L10 12.586l-2.293-2.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l4-4a1 1 0 000-1.414z" clip-rule="evenodd" />
                </svg>
                Login
            </a>
            <a href="{{ route('register') }}" 
               class="flex items-center justify-center w-full py-3 px-4 bg-gray-300 text-gray-800 rounded-lg shadow-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-400 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 4a6 6 0 00-5.917 5.5H3a1 1 0 000 2h1.083a6.001 6.001 0 0011.834 0H17a1 1 0 100-2h-1.083A6 6 0 0010 4zm0 2a4 4 0 110 8 4 4 0 010-8z" clip-rule="evenodd" />
                </svg>
                Register
            </a>
        </div>
    </div>
</body>
</html>