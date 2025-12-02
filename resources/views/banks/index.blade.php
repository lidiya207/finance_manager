@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Banks</h1>
            <p class="mt-2 text-gray-600">Manage your bank accounts</p>
        </div>
        <a href="{{ route('banks.create') }}" class="bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
            + Add Bank
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

    @if($banks->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($banks as $bank)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
                    <h3 class="text-xl font-bold text-white">{{ $bank->bank_name }}</h3>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                            {{ $bank->currency }}
                        </span>
                    </div>
                    <div class="flex items-center justify-end space-x-2 mt-4">
                        <a href="{{ route('banks.edit', $bank->id) }}" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</a>
                        <form action="{{ route('banks.destroy', $bank->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this bank?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No banks</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by adding your first bank account.</p>
            <div class="mt-6">
                <a href="{{ route('banks.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Add Bank
                </a>
            </div>
        </div>
    @endif
</div>
@endsection

