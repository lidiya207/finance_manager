<?php

namespace App\Http\Controllers;

use App\Models\IncomeSource;
use Illuminate\Http\Request;

class IncomeSourceController extends Controller
{
    public function index()
    {
        $sources = IncomeSource::where('user_id', auth()->id())->withCount('incomes')->latest()->get();
        return view('income-sources.index', compact('sources'));
    }

    public function create()
    {
        return view('income-sources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $validated['user_id'] = auth()->id();

        IncomeSource::create($validated);

        return redirect()->route('income-sources.index')->with('status', 'Income source created successfully!');
    }

    public function edit($id)
    {
        $source = IncomeSource::where('user_id', auth()->id())->findOrFail($id);
        return view('income-sources.edit', compact('source'));
    }

    public function update(Request $request, $id)
    {
        $source = IncomeSource::where('user_id', auth()->id())->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $source->update($validated);

        return redirect()->route('income-sources.index')->with('status', 'Income source updated successfully!');
    }

    public function destroy($id)
    {
        $source = IncomeSource::where('user_id', auth()->id())->findOrFail($id);
        
        // Check if source has incomes
        if ($source->incomes()->count() > 0) {
            return redirect()->route('income-sources.index')
                ->with('error', 'Cannot delete income source that has associated income records.');
        }
        
        $source->delete();

        return redirect()->route('income-sources.index')->with('status', 'Income source deleted successfully!');
    }
}
