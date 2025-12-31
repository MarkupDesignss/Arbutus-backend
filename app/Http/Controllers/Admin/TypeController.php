<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;

class TypeController extends Controller
{
    public function index(Request $request)
    {
        $query = Type::orderBy('id', 'desc');
        $data['types'] = $query->paginate(10)->withQueryString();
        return view('admin.types.index', $data);
    }

    public function create()
    {
        return view('admin.types.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $types = new Type();

        $types->name               = $request->name;       
        $types->status             = $request->status;
        $types->save();    
       
        return redirect()->route('admin.type.list')->with('success', 'Type created successfully!');
    }

    public function edit($id)
    {
        $data['types'] = Type::findOrFail($id);
        return view('admin.types.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $types = Type::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $types->update($validated);
        return redirect()->route('admin.type.list')->with('success', 'Type updated successfully!');
    }

    public function destroy($id)
    {
        $types = Type::findOrFail($id);
        $types->delete();
        return redirect()->route('admin.type.list')->with('success', 'Type deleted successfully.');
    }
}
