@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div class="center">
            <h1 class="text-3xl font-bold text-gray-900">Income Sources</h1>
            <p class="mt-2 text-gray-600">Manage your income sources</p>
        </div>
        <a href="{{ route('income-sources.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            + Add Source
        </a>
    </div>

    @if (session('status'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <p class="text-sm text-green-700">{{ session('status') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-r-lg">
            <p class="text-sm text-red-700">{{ session('error') }}</p>
        </div>
    @endif

    @if($sources->count() > 0)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Income Records</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($sources as $source)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $source->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $source->incomes_count }} record(s)
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                <a href="{{ route('income-sources.edit', $source->id) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                                <form action="{{ route('income-sources.destroy', $source->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this income source?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No income sources</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating your first income source.</p>
            <div class="mt-6">
                <a href="{{ route('income-sources.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    Add Income Source
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

