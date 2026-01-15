<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportJobRow;
use App\Models\Fund;
use Illuminate\Http\Request;

class ValidatedImportRowController extends Controller
{
    
    public function index()
    {
        // Get all fundatakeys from Fund table
        $validFundatakeys = Fund::pluck('fundatakey')->toArray();
        
        // Get ImportJobRow records that have fundatakey in Fund table
        $rows = ImportJobRow::whereIn('fundatakey', $validFundatakeys)
                    ->where('is_valid', 1)  // Only valid rows
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
