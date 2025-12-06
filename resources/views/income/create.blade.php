@extends('layouts.app')

@section('content')

<div class="max-w-4xl mx-auto px-8 sm:px-12 lg:px-16 py-16">

<!-- Success Toast -->
@if(session('success'))
<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
     class="fixed top-6 right-6 bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-4 z-50">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
    </svg>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Back Link -->
<div class="mb-10" style="margin-top: 2rem; margin-bottom: 2rem;">
    <a href="{{ route('income.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-all duration-200">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a1 1 0 01-.707-1.707l5-5H4a1 1 0 110-2h10.293l-5-5A1 1 0 1110.707 2.707l7 7a1 1 0 010 1.414l-7 7A1 1 0 0110 18z" clip-rule="evenodd" />
        </svg>
        Back to Income
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-3xl shadow-xl border border-gray-200 p-16 space-y-12">

    <!-- Header -->
    <div class="text-center mb-12">
        <h1 class="text-5xl font-extrabold text-gray-900 mb-3">Add Income</h1>
        <p class="text-gray-500 text-xl">Record a new income transaction</p>
    </div>

    <form method="POST" action="{{ route('income.store') }}" class="space-y-10" id="incomeForm">
        @csrf

        <!-- Amount -->
        <div>
            <label for="amount" class="block text-base font-semibold text-gray-900 mb-3">Amount <span class="text-red-500">*</span></label>
            <input type="number" 
                   id="amount" 
                   name="amount" 
                   step="0.01"
                   required
                   value="{{ old('amount') }}"
                   placeholder="0.00"
                   class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
            @error('amount')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Income Source -->
        <div>
            <label for="source_name" class="block text-base font-semibold text-gray-900 mb-3">Income Source <span class="text-red-500">*</span></label>
            <input type="text" 
                   id="source_name" 
                   name="source_name" 
                   list="source_list"
                   autocomplete="off"
                   required
                   value="{{ old('source_name') }}"
                   placeholder="Type or select an income source"
                   class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
            <datalist id="source_list">
                @foreach($sources as $source)
                    <option value="{{ $source->name }}" data-id="{{ $source->id }}">
                @endforeach
            </datalist>
            <input type="hidden" id="source_id" name="source_id" value="{{ old('source_id') }}">
            @error('source_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-gray-400">Type a new source name to create it automatically</p>
        </div>

        <!-- Bank -->
        <div>
            <label for="bank_name" class="block text-base font-semibold text-gray-900 mb-3">Bank <span class="text-red-500">*</span></label>
            <input type="text" 
                   id="bank_name" 
                   name="bank_name" 
                   list="bank_list"
                   autocomplete="off"
                   required
                   value="{{ old('bank_name') }}"
                   placeholder="Type or select a bank"
                   class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
            <datalist id="bank_list">
                @foreach($banks as $bank)
                    <option value="{{ $bank->bank_name }}" data-id="{{ $bank->id }}">
                @endforeach
            </datalist>
            <input type="hidden" id="bank_id" name="bank_id" value="{{ old('bank_id') }}">
            @error('bank_id')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-2 text-xs text-gray-400">Type a new bank name to create it automatically</p>
        </div>

        <!-- Currency & Date -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <label for="currency" class="block text-base font-semibold text-gray-900 mb-3">Currency <span class="text-red-500">*</span></label>
                <select id="currency" name="currency" required class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                    <option value="">Select currency</option>
                    <option value="USD" {{ old('currency') == 'USD' ? 'selected' : '' }}>USD ($)</option>
                    <option value="EUR" {{ old('currency') == 'EUR' ? 'selected' : '' }}>EUR (€)</option>
                    <option value="GBP" {{ old('currency') == 'GBP' ? 'selected' : '' }}>GBP (£)</option>
                    <option value="ETB" {{ old('currency') == 'ETB' ? 'selected' : '' }}>ETB (Br)</option>
                </select>
                @error('currency')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="occurred_at" class="block text-base font-semibold text-gray-900 mb-3">Date <span class="text-red-500">*</span></label>
                <input type="date" id="occurred_at" name="occurred_at" value="{{ old('occurred_at', date('Y-m-d')) }}" required class="w-full text-lg px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all">
                @error('occurred_at')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end gap-6 pt-10 border-t border-gray-200 mt-8" >
            <a href="{{ route('income.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all font-medium">
                Cancel
            </a>

            <button type="submit" class="px-6 py-3 bg-[#042d06] hover:bg-[#021b01] font-semibold rounded-lg text-white shadow-md transition-all" style="background-color: #042d06">
                Save Income
            </button>
        </div>

    </form>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sourceInput = document.getElementById('source_name');
    const sourceIdInput = document.getElementById('source_id');
    const sourceList = document.getElementById('source_list');
    sourceInput.addEventListener('input', function() {
        const selectedOption = Array.from(sourceList.options).find(option => option.value === this.value);
        sourceIdInput.value = selectedOption ? selectedOption.getAttribute('data-id') : '';
    });

    const bankInput = document.getElementById('bank_name');
    const bankIdInput = document.getElementById('bank_id');
    const bankList = document.getElementById('bank_list');
    bankInput.addEventListener('input', function() {
        const selectedOption = Array.from(bankList.options).find(option => option.value === this.value);
        bankIdInput.value = selectedOption ? selectedOption.getAttribute('data-id') : '';
    });
});
</script>

@endsection
