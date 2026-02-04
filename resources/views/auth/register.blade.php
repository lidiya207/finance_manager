@extends('layouts.app')

@section('title', 'Create Account - Finance Manager')

@section('content')
<!-- Modern Register Page with Gradient Background -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 p-6">

    <!-- Card Wrapper with Glassmorphism -->
    <div class="relative w-full max-w-md mx-auto fade-in-up">
        
        <!-- Floating Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-600 flex items-center justify-center shadow-2xl icon-pulse">
                <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 1C5.03 1 1 5.03 1 10s4.03 9 9 9 9-4.03 9-9S14.97 1 10 1zm.75 14.75v1.5h-1.5v-1.5c-1.72-.17-3-1.26-3-2.75h1.5c0 .83.88 1.5 2 1.5s2-.67 2-1.5-.88-1.5-2-1.5c-2.07 0-3.5-1.19-3.5-3s1.28-2.67 3-2.94v-1.56h1.5v1.56c1.72.27 3 1.39 3 2.94h-1.5c0-.83-.88-1.5-2-1.5s-2 .67-2 1.5.88 1.5 2 1.5c2.07 0 3.5 1.19 3.5 3s-1.28 2.58-3 2.75z"/>
                </svg>
            </div>
        </div>

        <!-- Main Card -->
        <div class="glass-card rounded-3xl overflow-hidden">
            
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 px-8 py-10 text-center relative overflow-hidden">
                <!-- Decorative circles -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>
                
                <h2 class="text-3xl font-extrabold text-white tracking-wide relative z-10">Create Account</h2>
                <p class="text-purple-100 text-sm mt-2 relative z-10">Join us and manage your finances with ease</p>
            </div>

            <!-- Form Section -->
            <div class="px-8 py-8 bg-white/80 backdrop-blur-sm">
                <form class="space-y-5" method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name Field -->
                    <div class="fade-in-up delay-100">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Full Name
                            </span>
                        </label>
                        <input id="name" name="name" type="text" required
                               value="{{ old('name') }}"
                               class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none
                                      transition-all duration-200 bg-white/50 backdrop-blur-sm
                                      hover:border-purple-300 @error('name') border-red-500 @enderror"
                               placeholder="Enter your full name">
                        @error('name')
                            <p class="mt-2 text-xs text-red-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="fade-in-up delay-200">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email Address
                            </span>
                        </label>
                        <input id="email" name="email" type="email" required
                               value="{{ old('email') }}"
                               class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none
                                      transition-all duration-200 bg-white/50 backdrop-blur-sm
                                      hover:border-purple-300 @error('email') border-red-500 @enderror"
                               placeholder="your.email@example.com">
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
                    <div class="fade-in-up delay-300">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                                Password
                            </span>
                        </label>
                        <input id="password" name="password" type="password" required
                               class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none
                                      transition-all duration-200 bg-white/50 backdrop-blur-sm
                                      hover:border-purple-300 @error('password') border-red-500 @enderror"
                               placeholder="Create a strong password">
                        @error('password')
                            <p class="mt-2 text-xs text-red-600 font-medium flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="fade-in-up delay-400">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Confirm Password
                            </span>
                        </label>
                        <input id="password-confirm" name="password_confirmation" type="password" required
                               class="block w-full px-4 py-3 text-sm border-2 border-gray-200 rounded-xl
                                      focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none
                                      transition-all duration-200 bg-white/50 backdrop-blur-sm
                                      hover:border-purple-300"
                               placeholder="Confirm your password">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit"
                            class="action-btn w-full py-4 bg-gradient-to-r from-purple-600 via-indigo-600 to-blue-600 
                                   text-white font-bold rounded-xl shadow-lg hover:shadow-2xl 
                                   transform hover:-translate-y-1 transition-all duration-200 text-sm
                                   fade-in-up delay-500">
                        <span class="flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                            Create Account
                        </span>
                    </button>

                    <!-- Login Link -->
                    <div class="text-center pt-6 border-t border-gray-200 fade-in-up delay-600">
                        <p class="text-sm text-gray-600">
                            Already have an account?
                            <a href="{{ route('login') }}" 
                               class="font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 transition-all">
                                Sign in here
                            </a>
                        </p>
                    </div>
                </form>
            </div>

        </div>

        <!-- Footer Text -->
        <p class="text-center text-sm text-gray-600 mt-6 fade-in-up delay-700">
            By creating an account, you agree to our 
            <a href="#" class="text-purple-600 hover:text-purple-700 font-semibold">Terms & Conditions</a>
        </p>

    </div>

</div>
@endsection
