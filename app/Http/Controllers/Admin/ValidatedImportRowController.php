<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportJobRow;
use App\Models\Fund;
use App\Models\FundMonthlyReturn;
use Illuminate\Http\Request;

class ValidatedImportRowController extends Controller
{
    
    public function index()
    {
        // Get all records from fund_monthly_returns table with fund relation
        $rows = FundMonthlyReturn::with('fund')
                    ->paginate(10);
        
        return view('admin.validated-import-row.index', compact('rows'));
    }

    public function destroy($id)
    {
        $row = ImportJobRow::findOrFail($id);
        $row->delete();
        
        return redirect()->route('validated-import-row.list')
                       ->with('success', 'Import row deleted successfully');
    }
}
