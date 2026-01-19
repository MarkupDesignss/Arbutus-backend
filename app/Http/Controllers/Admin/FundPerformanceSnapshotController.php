<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\FundMonthlyReturn;
use App\Models\FundPerformanceSnapshot;

class FundPerformanceSnapshotController extends Controller
{
    // Show the page with form and listing
    public function index()
    {
        // Build fund options based on what's present in fund_monthly_returns
        $fundOptions = FundMonthlyReturn::with('fund')
            ->select('fund_id', 'fundatakey')
            ->groupBy('fund_id', 'fundatakey')
            ->orderBy('fundatakey')
            ->get();

        $snapshots = FundPerformanceSnapshot::with('fund')->orderByDesc('id')->get();
        return view('admin.fund_performance_snapshots.index', compact('fundOptions', 'snapshots'));
    }

    // Return monthly returns for a fund (AJAX)
    public function months(Fund $fund)
    {
        $rows = FundMonthlyReturn::where('fund_id', $fund->id)
            ->orderByDesc('month_end')
            ->get(['month_end', 'monthly_return', 'distribution_yield']);

        return response()->json($rows);
    }

    // Store snapshot using values from Fund model for selected fund
    public function store(Request $request)
    {
        $data = $request->validate([
            'fund_id' => 'required|exists:funds,id',
            'as_of_month' => 'required|string'
        ]);

        $fund = Fund::findOrFail($data['fund_id']);

        // Prevent duplicate snapshot for same fund and month
        $exists = FundPerformanceSnapshot::where('fund_id', $fund->id)
            ->where('as_of_month', $data['as_of_month'])
            ->exists();

        if ($exists) {
            return redirect()->back()->withErrors(['as_of_month' => 'Snapshot for this fund and month already exists.'])->withInput();
        }

        FundPerformanceSnapshot::create([
            'fund_id' => $fund->id,
            'as_of_month' => $data['as_of_month'],
            'one_month' => $fund->one_month,
            'ytd' => $fund->ytd,
            'one_year' => $fund->one_year,
            'three_year' => $fund->three_year,
            'since_inception' => $fund->since_inception,
            'three_year_std_dev' => $fund->three_year_std_dev,
            'distribution_yield' => $fund->distribution_yield,
            'is_published' => $fund->status ?? 0,
        ]);

        return redirect()->back()->with('success', 'Performance snapshot saved.');
    }
}


