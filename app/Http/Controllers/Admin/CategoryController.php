<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::orderBy('id', 'desc');
        $data['categories'] = $query->paginate(10)->withQueryString();
        return view('admin.categories.index', $data);
    }

    public function create()
    {
        return view('admin.categories.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $categories = new Category();

        $categories->name               = $request->name;       
        $categories->status             = $request->status;
        $categories->save();    
       
        return redirect()->route('admin.category.list')->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $data['categories'] = Category::findOrFail($id);
        return view('admin.categories.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $categories = Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $categories->update($validated);
        return redirect()->route('admin.category.list')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $categories = Category::findOrFail($id);
        $categories->delete();
        return redirect()->route('admin.category.list')->with('success', 'Category deleted successfully.');
    }
}
