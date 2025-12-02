@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 via-blue-100 to-blue-200 p-6">

    <div class="w-full max-w-md">

        <!-- Modern Card -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-blue-100">

            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-6 py-10 text-center">

                <!-- Logo -->
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-full shadow-lg mb-4">
                    <svg class="w-12 h-12 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 1C5.03 1 1 5.03 1 10s4.03 9 9 9 9-4.03 9-9S14.97 1 10 1zm.75 14.75v1.5h-1.5v-1.5c-1.72-.17-3-1.26-3-2.75h1.5c0 .83.88 1.5 2 1.5s2-.67 2-1.5-.88-1.5-2-1.5c-2.07 0-3.5-1.19-3.5-3s1.28-2.67 3-2.94v-1.56h1.5v1.56c1.72.27 3 1.39 3 2.94h-1.5c0-.83-.88-1.5-2-1.5s-2 .67-2 1.5.88 1.5 2 1.5c2.07 0 3.5 1.19 3.5 3s-1.28 2.58-3 2.75z"/>
                    </svg>
                </div>

                <h2 class="text-3xl font-extrabold text-white tracking-wide">Welcome Back</h2>
                <p class="text-blue-100 text-sm mt-1">Sign in to manage your finances wisely</p>
            </div>

            <!-- Form -->
            <div class="px-8 py-8">
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">Email Address</label>

                        <div class="relative">
                            {{-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v.217L10 9 2 5.217V5z"></path>
                                    <path d="M18 8.383l-8 4-8-4V15a2 2 0 002 2h12a2 2 0 002-2V8.383z"></path>
                                </svg>
                            </div> --}}

                            <input id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                required
                                placeholder="Enter your email"
                                class="block w-full pl-11 pr-3 py-3 text-sm border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('email') border-red-500 @enderror">
                        </div>

                        @error('email')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block text-sm font-semibold text-blue-800 mb-2">Password</label>

                        <div class="relative">
                            {{-- <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div> --}}

                            <input id="password"
                                name="password"
                                type="password"
                                required
                                placeholder="Enter your password"
                                class="block w-full pl-11 pr-3 py-3 text-sm border-2 border-blue-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all @error('password') border-red-500 @enderror">
                        </div>

                        @error('password')
                            <p class="mt-2 text-xs text-red-600 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between text-xs">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="h-4 w-4 text-blue-600 border-blue-300 rounded"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-blue-800 font-medium">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="font-semibold text-blue-600 hover:text-blue-800 transition">
                            Forgot Password?
                        </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="w-full py-3 text-blue font-bold rounded-xl shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 text-sm">
                        Sign In
                    </button>

                    <!-- Register -->
                    <div class="text-center pt-4 border-t border-blue-100">
                        <p class="text-xxs text-blue-700">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="font-bold text-blue hover:text-blue-800">
                                Create one
                            </a>
                        </p>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
@endsection
