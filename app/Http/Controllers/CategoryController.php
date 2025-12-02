<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::where('user_id', auth()->id())->withCount('expenses')->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $validated['user_id'] = auth()->id();

        Category::create($validated);

        return redirect()->route('categories.index')->with('status', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255'
        ]);
        
        $category->update($validated);

        return redirect()->route('categories.index')->with('status', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::where('user_id', auth()->id())->findOrFail($id);
        
        // Check if category has expenses
        if ($category->expenses()->count() > 0) {
            return redirect()->route('categories.index')
                ->with('error', 'Cannot delete category that has associated expense records.');
        }
        
        $category->delete();

        return redirect()->route('categories.index')->with('status', 'Category deleted successfully!');
    }
}
