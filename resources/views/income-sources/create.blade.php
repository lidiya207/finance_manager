@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('income-sources.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Income Sources
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white">Add Income Source</h2>
        </div>

        <form method="POST" action="{{ route('income-sources.store') }}" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Source Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('name') border-red-500 @enderror" 
                       placeholder="e.g., Employer, Freelance, Family">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('income-sources.index') }}" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Create Source
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

