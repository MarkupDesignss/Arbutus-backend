<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Strategie;

class StrategieController extends Controller
{
    public function index(Request $request)
    {
        $query = Strategie::orderBy('id', 'desc');
        $data['strategies'] = $query->paginate(10)->withQueryString();
        return view('admin.strategies.index', $data);
    }

    public function create()
    {
        return view('admin.strategies.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $strategies = new Strategie();

        $strategies->name               = $request->name;       
        $strategies->status             = $request->status;
        $strategies->save();    
       
        return redirect()->route('admin.strategie.list')->with('success', 'Type created successfully!');
    }

    public function edit($id)
    {
        $data['strategies'] = Strategie::findOrFail($id);
        return view('admin.strategies.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $strategies = Strategie::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $strategies->update($validated);
        return redirect()->route('admin.strategie.list')->with('success', 'Strategie updated successfully!');
    }

    public function destroy($id)
    {
        $strategies = Strategie::findOrFail($id);
        $strategies->delete();
        return redirect()->route('admin.strategie.list')->with('success', 'Strategie deleted successfully.');
    }
}
