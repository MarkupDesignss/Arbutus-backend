<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Firm;

class FirmController extends Controller
{
    public function index(Request $request)
    {
        $query = Firm::orderBy('id', 'desc');
        $data['firms'] = $query->paginate(10)->withQueryString();

        return view('admin.firms.index', $data);
    }

    public function create()
    {
        return view('admin.firms.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:firms,name',
            'firm_aum'  => 'nullable|numeric|min:0',
            'status'    => 'required|in:0,1',
        ]);

        Firm::create($validated);

        return redirect()
            ->route('admin.firms.list')
            ->with('success', 'Firm created successfully!');
    }

    public function edit($id)
    {
        $data['firm'] = Firm::findOrFail($id);
        return view('admin.firms.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $firm = Firm::findOrFail($id);

        $validated = $request->validate([
            'name'      => 'required|string|max:255|unique:firms,name,' . $firm->id,
            'firm_aum'  => 'nullable|numeric|min:0',
            'status'    => 'required|in:0,1',
        ]);

        $firm->update($validated);

        return redirect()
            ->route('admin.firms.list')
            ->with('success', 'Firm updated successfully!');
    }

    public function destroy($id)
    {
        $firm = Firm::findOrFail($id);
        $firm->delete();

        return redirect()
            ->route('admin.firms.list')
            ->with('success', 'Firm deleted successfully!');
    }
}
