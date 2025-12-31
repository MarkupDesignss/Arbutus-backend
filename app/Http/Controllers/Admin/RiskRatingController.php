<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RiskRating;

class RiskRatingController extends Controller
{
    public function index(Request $request)
    {
        $query = RiskRating::orderBy('id', 'desc');
        $data['risk_rating'] = $query->paginate(10)->withQueryString();
        return view('admin.risk_rating.index', $data);
    }

    public function create()
    {
        return view('admin.risk_rating.add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $risk_rating = new RiskRating();

        $risk_rating->name               = $request->name;       
        $risk_rating->status             = $request->status;
        $risk_rating->save();    
       
        return redirect()->route('admin.risk.rating.list')->with('success', 'Risk rating created successfully!');
    }

    public function edit($id)
    {
        $data['risk_rating'] = RiskRating::findOrFail($id);
        return view('admin.risk_rating.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $risk_rating = RiskRating::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $risk_rating->update($validated);
        return redirect()->route('admin.risk.rating.list')->with('success', 'Risk rating updated successfully!');
    }

    public function destroy($id)
    {
        $risk_rating = RiskRating::findOrFail($id);
        $risk_rating->delete();
        return redirect()->route('admin.risk.rating.list')->with('success', 'Risk rating deleted successfully.');
    }
}
