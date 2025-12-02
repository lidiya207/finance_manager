@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 via-red-100 to-red-200 p-6">

    <!-- Card Wrapper -->
    <div class="relative w-full max-w-md mx-auto bg-white rounded-3xl shadow-[0_8px_30px_rgba(0,0,0,0.15)]
                hover:shadow-[0_12px_40px_rgba(0,0,0,0.20)] border border-blue-100 overflow-hidden transition-shadow duration-300">

        <!-- Floating Logo -->
        <div class="flex justify-center -mt-12">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white rounded-full shadow-xl">
                <svg class="w-14 h-14 text-blue-700" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 1C5.03 1 1 5.03 1 10s4.03 9 9 9 9-4.03 9-9S14.97 1 10 1zm.75 14.75v1.5h-1.5v-1.5c-1.72-.17-3-1.26-3-2.75h1.5c0 .83.88 1.5 2 1.5s2-.67 2-1.5-.88-1.5-2-1.5c-2.07 0-3.5-1.19-3.5-3s1.28-2.67 3-2.94v-1.56h1.5v1.56c1.72.27 3 1.39 3 2.94h-1.5c0-.83-.88-1.5-2-1.5s-2 .67-2 1.5.88 1.5 2 1.5c2.07 0 3.5 1.19 3.5 3s-1.28 2.58-3 2.75z"/>
                </svg>
            </div>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-700 to-blue-500 px-8 pt-16 pb-10 text-center">
            <h2 class="text-3xl font-extrabold text-white tracking-wide">Create Account</h2>
            <p class="text-blue-100 text-sm mt-2">Join us and manage your finance easily</p>
        </div>

        <!-- Form -->
        <div class="px-8 py-8">
            <form class="space-y-6" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-semibold text-red-800 mb-2">Full Name</label>
                    <input id="name" name="name" type="text" required
                           value="{{ old('name') }}"
                           class="block w-full px-4 py-3 text-sm border border-red-200 rounded-xl
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                  transition-all @error('name') border-red-500 @enderror"
                           placeholder="Enter your full name">
                    @error('name')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-red-800 mb-2">Email Address</label>
                    <input id="email" name="email" type="email" required
                           value="{{ old('email') }}"
                           class="block w-full px-4 py-3 text-sm border border-red-200 rounded-xl
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                  transition-all @error('email') border-red-500 @enderror"
                           placeholder="Enter your email">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-semibold text-red-800 mb-2">Password</label>
                    <input id="password" name="password" type="password" required
                           class="block w-full px-4 py-3 text-sm border border-red-200 rounded-xl
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                  transition-all @error('password') border-red-500 @enderror"
                           placeholder="Create a password">
                    @error('password')
                        <p class="mt-1 text-xs text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="block text-sm font-semibold text-red-800 mb-2">Confirm Password</label>
                    <input id="password-confirm" name="password_confirmation" type="password" required
                           class="block w-full px-4 py-3 text-sm border border-red-200 rounded-xl
                                  focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none
                                  transition-all"
                           placeholder="Confirm your password">
                </div>

                <!-- Submit -->
                <button type="submit"
                        class="w-full py-3 bg-gradient-to-r from-blue-700 to-blue-900 text-white font-bold rounded-xl
                               shadow-lg hover:shadow-xl transform hover:-translate-y-0.5
                               transition-all duration-200 text-sm">
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="text-center pt-4 border-t border-blue-100">
                    <p class="text-xxs text-blue-700">
                        Already have an account?
                        <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:text-blue-800 transition">
                            Sign in
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
