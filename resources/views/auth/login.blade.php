@extends('layouts.app')

@section('title', 'Sign In - Finance Manager')

@section('content')
<!-- Modern Login Page with Gradient Background -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-6">

    <div class="w-full max-w-md fade-in-up">

        <!-- Floating Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shadow-2xl icon-pulse">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 1C5.03 1 1 5.03 1 10s4.03 9 9 9 9-4.03 9-9S14.97 1 10 1zm.75 14.75v1.5h-1.5v-1.5c-1.72-.17-3-1.26-3-2.75h1.5c0 .83.88 1.5 2 1.5s2-.67 2-1.5-.88-1.5-2-1.5c-2.07 0-3.5-1.19-3.5-3s1.28-2.67 3-2.94v-1.56h1.5v1.56c1.72.27 3 1.39 3 2.94h-1.5c0-.83-.88-1.5-2-1.5s-2 .67-2 1.5.88 1.5 2 1.5c2.07 0 3.5 1.19 3.5 3s-1.28 2.58-3 2.75z"/>
                </svg>
            </div>
        </div>

        <!-- Modern Card with Glassmorphism -->
        <div class="glass-card rounded-3xl overflow-hidden">

            <!-- Header Section -->
            <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 px-8 py-10 text-center relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <h2 class="text-3xl font-extrabold text-white tracking-wide relative z-10">Welcome Back</h2>
                <p class="text-purple-100 text-sm mt-2 relative z-10">Sign in to manage your finances with ease</p>
            </div>

            <!-- Form Section -->
            <div class="px-8 py-8 bg-white/80 backdrop-blur-sm">
                <form class="space-y-6" method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="fade-in-up delay-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email Address
                            </span>
                        </label>

                        <input id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            placeholder="your.email@example.com"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                                   transition-all duration-200 bg-white/50 backdrop-blur-sm
                                   hover:border-indigo-300 @error('email') border-red-500 @enderror">

                        @error('email')
                            <p class="mt-2 text-xs text-red-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="fade-in-up delay-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Password
                            </span>
                        </label>

                        <input id="password"
                            name="password"
                            type="password"
                            required
                            placeholder="Enter your password"
                            class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                   focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none
                                   transition-all duration-200 bg-white/50 backdrop-blur-sm
                                   hover:border-indigo-300 @error('password') border-red-500 @enderror">

                        @error('password')
                            <p class="mt-2 text-xs text-red-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember + Forgot -->
                    <div class="flex items-center justify-between text-sm fade-in-up delay-300">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" 
                                   class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 transition-all"
                                   {{ old('remember') ? 'checked' : '' }}>
                            <span class="text-gray-700 font-medium group-hover:text-indigo-600 transition-colors">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" 
                           class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all">
                            Forgot Password?
                        </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit"
                        class="action-btn w-full py-4 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 
                               text-white font-bold rounded-xl shadow-lg hover:shadow-2xl 
                               transform hover:-translate-y-1 transition-all duration-200 text-sm
                               fade-in-up delay-400">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                            </svg>
                            Sign In
                        </span>
                    </button>

                    <!-- Register Link -->
                    <div class="text-center pt-6 border-t border-gray-200 fade-in-up delay-500">
                        <p class="text-sm text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}" 
                               class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 transition-all">
                                Create one here
                            </a>
                        </p>
                    </div>

                </form>
            </div>

        </div>

        <!-- Footer Text -->
        <p class="text-center text-sm text-gray-600 mt-6 fade-in-up delay-600">
            Secure login powered by 
            <span class="font-semibold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">Finance Manager</span>
        </p>

    </div>
</div>
@endsection
