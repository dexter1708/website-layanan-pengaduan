{{-- <x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex items-center justify-center bg-cover bg-center"
    style="background-image: url('{{ asset('assets/image.png') }}');">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('assets/image.png') }}" alt="logo" class="h-15 w-20">
        </div>

        <!-- Title & Register -->
        <div class="flex justify-center items-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Login</h3>
        </div>

        <!-- Login Form -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input name="email" type="email" placeholder="Email Address" value="{{ old('email') }}" required
                    autofocus
                    class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input name="password" type="password" placeholder="Password" required
                    class="w-full mt-1 px-3 py-2 border rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500" />
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me + Forgot -->
            <div class="flex justify-end items-end mb-4">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-500 hover:underline">Lupa
                    Password?</a>
            </div>

            <!-- Login Button -->
            <div class="mb-4">
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition">
                    Login
                </button>
            </div>
        </form>

        <!-- Separator -->
        <div class="relative text-center mb-4">
            <span class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full border-t border-gray-200"></span>
            <span class="relative px-3 bg-white text-sm text-gray-500">Belum punya akun? Register <a href=""
                    class="text-sm text-blue-500 hover:underline">disini</a></span>
        </div>
    </div>
</body>

</html>
