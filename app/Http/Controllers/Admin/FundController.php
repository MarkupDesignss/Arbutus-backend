<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\Firm;
use App\Models\AssetClass;
use App\Models\Type;
use App\Models\Strategie;
use App\Models\Category;
use App\Models\RiskRating;
use App\Models\FundMonthlyReturn;
use App\Models\ImportJobRow;

class FundController extends Controller
{
    public function index()
    {
        $data['funds'] = Fund::with(['firm','assetClass','type','strategy','category','riskRating'])
                            ->orderBy('id','desc')
                            ->paginate(10);

        return view('admin.funds.index', $data);
    }

    public function create()
    {
        $data['firms'] = Firm::where('status',1)->get();
        $data['asset_classes'] = AssetClass::where('status',1)->get();
        $data['types'] = Type::where('status',1)->get();
        $data['strategies'] = Strategie::where('status',1)->get();
        $data['categories'] = Category::where('status',1)->get();
        $data['risk_ratings'] = RiskRating::where('status',1)->get();

        return view('admin.funds.add', $data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fundatakey' => 'required|string|max:255|unique:funds,fundatakey',
            'symbol_code' => 'nullable|string|max:255',
            'fund_name' => 'required|string|max:255',
            'firm_id' => 'required|exists:firms,id',
            'asset_class_id' => 'required|exists:asset_classes,id',
            'type_id' => 'required|exists:types,id',
            'strategy_id' => 'required|exists:strategies,id',
            'category_id' => 'required|exists:categories,id',
            'risk_rating_id' => 'required|exists:risk_ratings,id',
            'one_month' => 'nullable|numeric',
            'ytd' => 'nullable|numeric',
            'one_year' => 'nullable|numeric',
            'three_year' => 'nullable|numeric',
            'since_inception' => 'nullable|numeric',
            'three_year_std_dev' => 'nullable|numeric',
            'distribution_yield' => 'nullable|numeric',
            'inception_date' => 'nullable|date',
            'fund_aum' => 'nullable|numeric',
            'fund_library_link' => 'nullable|url',
            'external_link' => 'nullable|url',
            'status' => 'required|in:0,1',
        ]);

        Fund::create($validated);

        return redirect()->route('admin.funds.list')->with('success', 'Fund created successfully!');
    }

    public function edit($id)
    {
        $data['fund'] = Fund::findOrFail($id);
        $data['firms'] = Firm::where('status',1)->get();
        $data['asset_classes'] = AssetClass::where('status',1)->get();
        $data['types'] = Type::where('status',1)->get();
        $data['strategies'] = Strategie::where('status',1)->get();
        $data['categories'] = Category::where('status',1)->get();
        $data['risk_ratings'] = RiskRating::where('status',1)->get();

        return view('admin.funds.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $fund = Fund::findOrFail($id);

        $validated = $request->validate([
            'fundatakey' => 'required|string|max:255|unique:funds,fundatakey,' . $fund->id,
            'symbol_code' => 'nullable|string|max:255',
            'fund_name' => 'required|string|max:255',
            'firm_id' => 'required|exists:firms,id',
            'asset_class_id' => 'required|exists:asset_classes,id',
            'type_id' => 'required|exists:types,id',
            'strategy_id' => 'required|exists:strategies,id',
            'category_id' => 'required|exists:categories,id',
            'risk_rating_id' => 'required|exists:risk_ratings,id',
            'one_month' => 'nullable|numeric',
            'ytd' => 'nullable|numeric',
            'one_year' => 'nullable|numeric',
            'three_year' => 'nullable|numeric',
            'since_inception' => 'nullable|numeric',
            'three_year_std_dev' => 'nullable|numeric',
            'distribution_yield' => 'nullable|numeric',
            'inception_date' => 'nullable|date',
            'fund_aum' => 'nullable|numeric',
            'fund_library_link' => 'nullable|url',
            'external_link' => 'nullable|url',
            'status' => 'required|in:0,1',
        ]);

        $fund->update($validated);

        return redirect()->route('admin.funds.list')->with('success', 'Fund updated successfully!');
    }

    public function destroy($id)
    {
        $fund = Fund::findOrFail($id);
        
        // Delete related records from ImportJobRow table
        ImportJobRow::where('fundatakey', $fund->fundatakey)->delete();
        
        // Delete related records from FundMonthlyReturn table
        FundMonthlyReturn::where('fund_id', $fund->id)->delete();
        
        // Delete the fund
        $fund->delete();

        return redirect()->route('admin.funds.list')->with('success', 'Fund deleted successfully!');
    }

    // Show Fund Details
    public function show($id)
    {
        $fund = Fund::with(['firm','assetClass','type','strategy','category','riskRating'])->findOrFail($id);
        return view('admin.funds.view', compact('fund'));
    }
}
