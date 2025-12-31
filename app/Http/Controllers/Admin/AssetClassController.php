<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AssetClass;

class AssetClassController extends Controller
{
    public function index(Request $request)
    {
        $query = AssetClass::orderBy('id', 'desc');
        $data['classes'] = $query->paginate(10)->withQueryString();
        return view('admin.asset-class.index', $data);
    }

    public function create()
    {
        return view('admin.asset-class.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $classes = new AssetClass();

        $classes->name               = $request->name;       
        $classes->status             = $request->status;
        $classes->save();    
       
        return redirect()->route('admin.asset.class.list')->with('success', 'Asset Class created successfully!');
    }

    public function edit($id)
    {
        $data['classes'] = AssetClass::findOrFail($id);
        return view('admin.asset-class.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $classes = AssetClass::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $classes->update($validated);
        return redirect()->route('admin.asset.class.list')->with('success', 'Asset Class updated successfully!');
    }

    public function destroy($id)
    {
        $classes = AssetClass::findOrFail($id);
        $classes->delete();
        return redirect()->route('admin.asset.class.list')->with('success', 'Asset Class deleted successfully.');
    }
}
