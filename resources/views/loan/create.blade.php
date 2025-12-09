@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Back Link -->
    <div class="mb-6" style="margin-top: 2rem" >
        <a href="{{ route('loans.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Loans
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 ">
        <!-- Header -->
        <div class="mb-8 text-center" >
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Add Loan</h1>
            <p class="text-gray-600 text-sm">Record a new loan transaction</p>
        </div>

        <form method="POST" action="{{ route('loans.store') }}" class="space-y-8">
            @csrf

            <!-- Loan Type -->
            <div class="mb-6">
                <label for="type" class="block text-sm font-medium text-gray-900 mb-2">
                    Loan Type <span class="text-red-500">*</span>
                </label>
                <select id="type" 
                        name="type" 
                        required
                        class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('type') border-red-500 @enderror">
                    <option value="">Select loan type</option>
                    <option value="given" {{ old('type') == 'given' ? 'selected' : '' }}>Given (You lent money)</option>
                    <option value="taken" {{ old('type') == 'taken' ? 'selected' : '' }}>Taken (You borrowed money)</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Person Name -->
            <div class="mb-6">
                <label for="person_name" class="block text-sm font-medium text-gray-900 mb-2">
                    Person Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="person_name" 
                       name="person_name" 
                       value="{{ old('person_name') }}"
                       required
                       class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('person_name') border-red-500 @enderror" 
                       placeholder="Enter person's name">
                @error('person_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Person Contact -->
            <div class="mb-6">
                <label for="person_contact" class="block text-sm font-medium text-gray-900 mb-2">
                    Contact (Optional)
                </label>
                <input type="text" 
                       id="person_contact" 
                       name="person_contact" 
                       value="{{ old('person_contact') }}"
                       class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('person_contact') border-red-500 @enderror" 
                       placeholder="Phone or email">
                @error('person_contact')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Reason -->
            <div class="mb-6">
                <label for="reason" class="block text-sm font-medium text-gray-900 mb-2">
                    Reason (Optional)
                </label>
                <textarea id="reason" 
                          name="reason" 
                          rows="3"
                          class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('reason') border-red-500 @enderror" 
                          placeholder="Reason for the loan">{{ old('reason') }}</textarea>
                @error('reason')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Principal Amount -->
            <div class="mb-6">
                <label for="principal_amount" class="block text-sm font-medium text-gray-900 mb-2">
                    Principal Amount <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-base">$</span>
                    </div>
                    <input type="number" 
                           id="principal_amount" 
                           name="principal_amount" 
                           step="0.01"
                           value="{{ old('principal_amount') }}"
                           required
                           class="block w-full pl-8 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('principal_amount') border-red-500 @enderror" 
                           placeholder="0.00">
                </div>
                @error('principal_amount')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Outstanding Balance -->
            <div class="mb-6">
                <label for="outstanding_balance" class="block text-sm font-medium text-gray-900 mb-2">
                    Outstanding Balance <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <span class="text-gray-500 text-base">$</span>
                    </div>
                    <input type="number" 
                           id="outstanding_balance" 
                           name="outstanding_balance" 
                           step="0.01"
                           value="{{ old('outstanding_balance') }}"
                           required
                           class="block w-full pl-8 pr-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('outstanding_balance') border-red-500 @enderror" 
                           placeholder="0.00">
                </div>
                @error('outstanding_balance')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bank -->
            <div class="mb-6">
                <label for="bank_id" class="block text-sm font-medium text-gray-900 mb-2">
                    Bank <span class="text-red-500">*</span>
                </label>
                <select id="bank_id" 
                        name="bank_id" 
                        required
                        style="appearance: auto; -webkit-appearance: menulist; -moz-appearance: menulist;"
                        class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('bank_id') border-red-500 @enderror">
                    <option value="">Select a bank</option>
                    @foreach($banks as $bank)
                        <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                            {{ $bank->bank_name }}
                        </option>
                    @endforeach
                </select>
                @error('bank_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Currency -->
            <div class="mb-6">
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

            <!-- Status -->
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-900 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status" 
                        name="status" 
                        required
                        class="block w-full px-4 py-3 text-base border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-all @error('status') border-red-500 @enderror">
                    <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-200">
                <a href="{{ route('loans.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 font-semibold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg border-0" style="color: white !important; background-color: #042d06">
                    <span style="color: white !important;">Save Loan</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
