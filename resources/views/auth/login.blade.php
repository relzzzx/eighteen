<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Eighteen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-50 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-md rounded-lg p-8 max-w-md w-full">
        <h1 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Log in ke <span class="text-blue-500">Eighteen</span></h1>

        <!-- Session Status -->
        <div id="session-status" class="mb-4 text-sm text-green-500 hidden"></div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="username" 
                    class="block w-full rounded-lg border-gray-300 shadow-md focus:ring-blue-500 focus:border-blue-500 text-lg py-3 px-4" 
                    value="{{ old('email') }}">
                <p class="text-red-500 text-sm mt-2 hidden" id="email-error"></p>
            </div>

            <!-- Password -->
            <div class="mt-6">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" 
                    class="block w-full rounded-lg border-gray-300 shadow-md focus:ring-blue-500 focus:border-blue-500 text-lg py-3 px-4">
                <p class="text-red-500 text-sm mt-2 hidden" id="password-error"></p>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center mt-6">
                <input id="remember_me" type="checkbox" name="remember" 
                    class="h-5 w-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="remember_me" class="ml-2 block text-sm text-gray-800">Remember me</label>
            </div>

            <!-- Forgot Password -->
            <div class="flex items-center justify-between mt-8">
                <a href="{{ route('password.request') }}" 
                   class="text-sm text-gray-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                   Forgot your password?
                </a>
                <button type="submit" 
                        class="py-3 px-6 bg-blue-500 text-white rounded-lg shadow-md text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Log in
                </button>
            </div>
        </form>
    </div>
</body>
</html>