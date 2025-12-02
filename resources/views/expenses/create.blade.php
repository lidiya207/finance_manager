@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Link -->
    <div class="mb-6">
        <a href="{{ route('expenses.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Expenses
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Add Expense</h1>
            <p class="text-gray-600 text-sm">Record a new expense transaction</p>
        </div>

        <form method="POST" action="{{ route('expenses.store') }}" class="space-y-6" id="expenseForm">
            @csrf

            <!-- Amount -->
            <div>
                <label for="amount" class="block text-sm font-medium text-gray-900 mb-2">
                    Amount <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-base">$</span>
                    </div>
                    <input type="number" 
                           id="amount" 
                           name="amount" 
                           step="0.01"
                           required
                           value="{{ old('amount') }}"
                           class="block w-full pl-8 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('amount') border-red-500 @enderror" 
                           placeholder="0.00">
                </div>
                @error('amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-900 mb-2">
                    Category <span class="text-red-500">*</span>
                </label>
                <select id="category_id" 
                        name="category_id" 
                        required
                        class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('category_id') border-red-500 @enderror">
                    <option value="">Select a category</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bank -->
            <div>
                <label for="bank_name" class="block text-sm font-medium text-gray-900 mb-2">
                    Bank <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="bank_name" 
                       name="bank_name" 
                       list="bank_list"
                       autocomplete="off"
                       required
                       value="{{ old('bank_name') }}"
                       placeholder="Type or select a bank"
                       class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('bank_id') border-red-500 @enderror">
                <datalist id="bank_list">
                    @foreach($banks as $bank)
                        <option value="{{ $bank->bank_name }}" data-id="{{ $bank->id }}">
                    @endforeach
                </datalist>
                <input type="hidden" id="bank_id" name="bank_id" value="{{ old('bank_id') }}">
                @error('bank_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-2 text-xs text-gray-500">Type a new bank name to create it automatically</p>
            </div>

            <!-- Currency -->
            <div>
                <label for="currency" class="block text-sm font-medium text-gray-900 mb-2">
                    Currency <span class="text-red-500">*</span>
                </label>
                <select id="currency" 
                        name="currency" 
                        required
                        class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('currency') border-red-500 @enderror">
                    <option value="">Select currency</option>
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                    <option value="ETB" {{ old('currency') == 'ETB' ? 'selected' : '' }}>ETB (Br)</option>
                </select>
                @error('currency')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Date -->
            <div>
                <label for="occurred_at" class="block text-sm font-medium text-gray-900 mb-2">
                    Date <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       id="occurred_at" 
                       name="occurred_at" 
                       value="{{ old('occurred_at', date('Y-m-d')) }}"
                       required
                       class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('occurred_at') border-red-500 @enderror">
                @error('occurred_at')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('expenses.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 font-semibold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg border-0" style="color: white !important; background-color: #2563eb !important;">
                    <span style="color: white !important;">Save Expense</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bankInput = document.getElementById('bank_name');
    const bankIdInput = document.getElementById('bank_id');
    const bankList = document.getElementById('bank_list');

    // Handle bank selection
    bankInput.addEventListener('input', function() {
        const selectedOption = Array.from(bankList.options).find(
            option => option.value === this.value
        );
        if (selectedOption) {
            bankIdInput.value = selectedOption.getAttribute('data-id');
        } else {
            bankIdInput.value = '';
        }
    });
});
</script>
@endsection
