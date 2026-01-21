<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Fund;
use App\Models\FundMonthlyReturn;
use App\Models\FundPerformanceSnapshot;
use Carbon\Carbon;

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

        // Parse as_of_month and prepare date bounds
        $asOf = Carbon::parse($data['as_of_month']);
        $asOfEnd = $asOf->copy()->endOfMonth()->toDateString();

        // Helper to compute compound return from a collection
        $compoundReturn = function ($rows) {
            $prod = 1.0;
            foreach ($rows as $r) {
                $mv = is_null($r->monthly_return) ? 0 : floatval($r->monthly_return);
                $prod *= (1 + $mv);
            }
            return $prod - 1;
        };

        // Latest single month (one_month)
        $oneMonthRow = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderByDesc('month_end')
            ->first();

        $one_month = $oneMonthRow->monthly_return ?? null;

        // YTD: from Jan of the year up to as_of_month
        $yearStart = $asOf->copy()->startOfYear()->toDateString();
        $ytdRows = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '>=', $yearStart)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderBy('month_end')
            ->get();

        $ytd = count($ytdRows) ? $compoundReturn($ytdRows) : null;

        // One year: last up to 12 months ending at as_of_month
        $oneYearRows = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderByDesc('month_end')
            ->limit(12)
            ->get();

        $one_year = count($oneYearRows) ? $compoundReturn($oneYearRows) : null;

        // Three year: last up to 36 months, annualized to 3 years if possible
        $threeYearRows = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderByDesc('month_end')
            ->limit(36)
            ->get();

        if (count($threeYearRows)) {
            $compound = $compoundReturn($threeYearRows);
            $months = count($threeYearRows);
            if ($months >= 36) {
                $three_year = pow(1 + $compound, 1/3) - 1;
            } else {
                $three_year = pow(1 + $compound, 12/$months) - 1;
            }
        } else {
            $three_year = null;
        }

        // Since inception: all months up to as_of_month, annualized
        $allRows = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderBy('month_end')
            ->get();

        if (count($allRows)) {
            $compoundAll = $compoundReturn($allRows);
            $totalMonths = count($allRows);
            $since_inception = pow(1 + $compoundAll, 12 / $totalMonths) - 1;
        } else {
            $since_inception = null;
        }

        // Three year std dev: stddev of last 36 monthly returns (population) * sqrt(12)
        if (count($threeYearRows)) {
            $vals = $threeYearRows->pluck('monthly_return')->map(function ($v) { return floatval($v); })->toArray();
            $n = count($vals);
            $mean = array_sum($vals) / $n;
            $sumSq = 0.0;
            foreach ($vals as $v) {
                $d = $v - $mean;
                $sumSq += $d * $d;
            }
            $variance = $n > 0 ? ($sumSq / $n) : 0;
            $monthlyStd = sqrt($variance);
            $three_year_std_dev = $monthlyStd * sqrt(12);
        } else {
            $three_year_std_dev = null;
        }

        // Distribution yield: take latest distribution_yield up to as_of_month
        $distRow = FundMonthlyReturn::where('fund_id', $fund->id)
            ->whereDate('month_end', '<=', $asOfEnd)
            ->orderByDesc('month_end')
            ->first();

        $distribution_yield = $distRow->distribution_yield ?? null;

        FundPerformanceSnapshot::create([
            'fund_id' => $fund->id,
            'as_of_month' => $data['as_of_month'],
            'one_month' => $one_month,
            'ytd' => $ytd,
            'one_year' => $one_year,
            'three_year' => $three_year,
            'since_inception' => $since_inception,
            'three_year_std_dev' => $three_year_std_dev,
            'distribution_yield' => $distribution_yield,
            'is_published' => 0,
        ]);

        return redirect()->back()->with('success', 'Performance snapshot saved.');
    }

    // Show details for a single snapshot
    public function show($id)
    {
        $snapshot = FundPerformanceSnapshot::with('fund')->findOrFail($id);

        // Parse as_of_month to fetch monthly returns up to that month
        $asOf = Carbon::parse($snapshot->as_of_month)->endOfMonth()->toDateString();

        $monthlyReturns = FundMonthlyReturn::where('fund_id', $snapshot->fund_id)
            ->whereDate('month_end', '<=', $asOf)
            ->orderByDesc('month_end')
            ->get(['month_end', 'monthly_return', 'distribution_yield']);

        return view('admin.fund_performance_snapshots.show', compact('snapshot', 'monthlyReturns'));
    }

    // Toggle published status (AJAX or normal POST)
    public function toggle(Request $request, $id)
    {
        $snapshot = FundPerformanceSnapshot::findOrFail($id);
        $snapshot->is_published = $snapshot->is_published ? 0 : 1;
        $snapshot->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['is_published' => (int)$snapshot->is_published]);
        }

        return redirect()->back();
    }

    // Delete a snapshot
    public function destroy($id)
    {
        $snapshot = FundPerformanceSnapshot::findOrFail($id);
        $snapshot->delete();    
        return redirect()->back()->with('success', 'Performance snapshot deleted.');

    }
}


