@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <a href="{{ route('categories.index') }}" class="inline-flex items-center text-red-600 hover:text-red-800 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Categories
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-red-800 px-6 py-4 text-center">
            <h2 class="text-4xl font-bold text-red-50">Create New Category</h2>
        </div>

        <form method="POST" action="{{ route('categories.store') }}" class="p-6">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-medium text-red-800 mb-2">
                    Category Name <span class="text-red-600">*</span>
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required
                       placeholder="Enter category name"
                       class="block w-full px-4 py-3 border-2 border-red-200 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('categories.index') }}" class="px-6 py-3 border-2 border-red-200 rounded-lg text-red-700 hover:bg-red-50 transition-colors font-medium">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-red-50 rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                    Create Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

