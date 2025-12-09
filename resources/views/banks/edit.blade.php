@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-8 sm:px-12 lg:px-16 py-16">

    <!-- Back Link -->
    <div class="mb-10" style="margin-top: 2rem; margin-bottom: 2rem;">
        <a href="{{ route('banks.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-all duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-1.707l5-5H4a1 1 0 110-2h10.293l-5-5A1 1 0 1110.707 2.707l7 7a1 1 0 010 1.414l-7 7A1 1 0 0110 18z" clip-rule="evenodd" />
            </svg>
            Back to Banks
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-16 space-y-12">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-extrabold text-gray-900 mb-3">Edit Bank</h1>
            <p class="text-gray-500 text-xl">Update bank account details</p>
        </div>

        <form method="POST" action="{{ route('banks.update', $bank->id) }}" class="space-y-10">
            @csrf
            @method('PUT')

            <!-- Bank Name -->
            <div>
                <label for="bank_name" class="block text-base font-semibold text-gray-900 mb-3">Bank Name <span class="text-red-500">*</span></label>
                <input type="text" 
                       id="bank_name" 
                       name="bank_name" 
                       required
                       value="{{ old('bank_name', $bank->bank_name) }}"
                       placeholder="e.g. Chase, Bank of America"
                       class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                @error('bank_name')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Currency -->
            <div>
                <label for="currency" class="block text-base font-semibold text-gray-900 mb-3">Currency <span class="text-red-500">*</span></label>
                <select id="currency" name="currency" required class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all">
                    <option value="">Select currency</option>
                    @foreach(['IDR', 'USD', 'EUR', 'GBP', 'ETB'] as $curr)
                        <option value="{{ $curr }}" {{ old('currency', $bank->currency) == $curr ? 'selected' : '' }}>
                            {{ $curr }}
                        </option>
                    @endforeach
                </select>
                @error('currency')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-200 mt-8">
                <a href="{{ route('banks.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all font-medium">
                    Cancel
                </a>

                <button type="submit" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 font-semibold rounded-lg text-white shadow-md transition-all">
                    Update Bank
                </button>
            </div>

        </form>
    </div>

</div>

@endsection
