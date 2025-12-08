@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto px-4 py-8">

    <h2 class="text-2xl font-bold mb-6">Edit Loan</h2>

    <form action="{{ route('loans.update', $loan->id) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')

        {{-- Type --}}
        <div>
            <label class="block font-medium">Loan Type</label>
            <select name="type" class="w-full border rounded-lg px-3 py-2">
                <option value="given" {{ $loan->type == 'given' ? 'selected' : '' }}>Given</option>
                <option value="taken" {{ $loan->type == 'taken' ? 'selected' : '' }}>Taken</option>
            </select>
        </div>

        {{-- Person Name --}}
        <div>
            <label class="block font-medium">Person Name</label>
            <input type="text" name="person_name" value="{{ $loan->person_name }}"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        {{-- Contact --}}
        <div>
            <label class="block font-medium">Person Contact</label>
            <input type="text" name="person_contact" value="{{ $loan->person_contact }}"
                   class="w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Reason --}}
        <div>
            <label class="block font-medium">Reason</label>
            <textarea name="reason" class="w-full border rounded-lg px-3 py-2">{{ $loan->reason }}</textarea>
        </div>

        {{-- Principal --}}
        <div>
            <label class="block font-medium">Principal Amount</label>
            <input type="number" step="0.01" name="principal_amount" value="{{ $loan->principal_amount }}"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        {{-- Balance --}}
        <div>
            <label class="block font-medium">Outstanding Balance</label>
            <input type="number" step="0.01" name="outstanding_balance" value="{{ $loan->outstanding_balance }}"
                   class="w-full border rounded-lg px-3 py-2" required>
        </div>

        {{-- Currency --}}
        <div>
            <label class="block font-medium">Currency</label>
            <select name="currency" class="w-full border rounded-lg px-3 py-2">
                <option value="ETB" {{ $loan->currency == 'ETB' ? 'selected' : '' }}>ETB</option>
                <option value="USD" {{ $loan->currency == 'USD' ? 'selected' : '' }}>USD</option>
            </select>
        </div>

        {{-- Bank --}}
        <div>
            <label class="block font-medium">Bank</label>
            <select name="bank_id" 
                    style="appearance: auto; -webkit-appearance: menulist; -moz-appearance: menulist;"
                    class="w-full border rounded-lg px-3 py-2">
                @foreach($banks as $bank)
                    <option value="{{ $bank->id }}" {{ $loan->bank_id == $bank->id ? 'selected' : '' }}>
                        {{ $bank->bank_name }} ({{ $bank->currency }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Status --}}
        <div>
            <label class="block font-medium">Status</label>
            <select name="status" class="w-full border rounded-lg px-3 py-2">
                <option value="open" {{ $loan->status == 'open' ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ $loan->status == 'closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        {{-- Update Button --}}
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 w-full">
            Update Loan
        </button>
    </form>
</div>

@endsection
