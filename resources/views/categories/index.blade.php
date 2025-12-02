@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="text-center flex-1">
            <h1 class="text-5xl font-bold text-red-800">Categories</h1>
            <p class="mt-2 text-xl text-red-700">View and manage your expense categories</p>
        </div>
        <a href="{{ route('categories.create') }}" class="bg-gradient-to-r from-red-600 to-red-800 hover:from-red-700 hover:to-red-900 text-red-50 px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            + Add Category
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <p class="text-sm text-red-700">{{ session('status') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 p-4 rounded-r-lg">
            <p class="text-sm text-red-800">{{ session('error') }}</p>
        </div>
    @endif

    @if($categories->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-red-200">
                    <thead class="bg-red-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Category Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Expenses Count</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Created At</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-red-800 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-red-100">
                        @foreach($categories as $category)
                        <tr class="hover:bg-red-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-red-900">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">
                                {{ $category->expenses_count }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-red-700">
                                {{ \Carbon\Carbon::parse($category->created_at)->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex items-center space-x-3">
                                    <a href="{{ route('categories.edit', $category->id) }}" class="text-red-600 hover:text-red-800 transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-red-800">No categories</h3>
            <p class="mt-1 text-sm text-red-700">Get started by creating your first category.</p>
            <div class="mt-6">
                <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 text-sm text-red-50 bg-red-600 hover:bg-red-700 rounded-md shadow-sm">
                    Add Category
                </a>
            </div>
        </div>
    @endif
</div>
@endsection





