<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportJob;
use App\Models\Admin;
use App\Models\ImportJobRow;
use App\Models\Fund;
use App\Models\FundMonthlyReturn;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


class ImportJobController extends Controller
{
    public function index()
    {
        $data['jobs'] = ImportJob::with('admin')->orderBy('id','desc')->paginate(10);
        return view('admin.import-jobs.index', $data);
    }

    public function create()
    {
        $data['admins'] = Admin::where('status',1)->get();
        return view('admin.import-jobs.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_id'    => 'required|exists:admins,id',
            'csv_file'    => 'required|mimes:csv,xlsx,xls',
            'status'      => 'required',
            'as_of_month' => 'required',
        ]);

        // convert month
        $asOfMonth = $request->as_of_month . '-01';

        // Save file
        $file = $request->file('csv_file');
        $originalName = $file->getClientOriginalName();
        $storedName = time().'_'.$originalName;
        $path = $file->storeAs('import_jobs', $storedName, 'public');

        // Create Import Job
        $job = ImportJob::create([
            'admin_id' => $request->admin_id,
            'original_filename' => $originalName,
            'stored_filename' => $storedName,
            'status' => $request->status,
            'as_of_month' => $asOfMonth,
        ]);

        // Read rows from Excel
        $rows = Excel::toArray([], storage_path('app/public/'.$path))[0];

        $total = $valid = $invalid = 0;

        foreach($rows as $i => $row)
        {
            if ($i == 0) continue; // skip header

            $total++;

            $fundatakey = $row[0] ?? null;

            // Month parsing
            $month_end = isset($row[1]) ? Carbon::parse($row[1])->format('Y-m-d') : null;

            // Monthly return as float
            $monthly_return = isset($row[2]) ? floatval($row[2]) : null;

            // Distribution yield: remove % and convert to float
            $distribution_yield = null;
            if(isset($row[3])) {
                $distribution_yield = floatval(str_replace('%','',$row[3]));
            }

            $isValid = $fundatakey && $month_end && $monthly_return !== null && $distribution_yield !== null;

            // Always save to ImportJobRow
            ImportJobRow::create([
                'import_job_id' => $job->id,
                'fundatakey' => $fundatakey,
                'month_end' => $month_end,
                'monthly_return' => $monthly_return,
                'distribution_yield' => $distribution_yield,
                'is_valid' => $isValid,
                'errors' => $isValid ? null : json_encode(['Invalid numeric data'])
            ]);

            // If valid, check if fundatakey matches a fund in the funds table
            if ($isValid) {
                $fund = Fund::where('fundatakey', $fundatakey)->first();
                
                if ($fund) {
                    // Save to FundMonthlyReturn with fund_id
                    FundMonthlyReturn::create([
                        'fund_id' => $fund->id,
                        'fundatakey' => $fundatakey,
                        'month_end' => $month_end,
                        'monthly_return' => $monthly_return,
                        'distribution_yield' => $distribution_yield
                    ]);
                }
            }

            $isValid ? $valid++ : $invalid++;
        }

        $job->update([
            'total_rows' => $total,
            'valid_rows' => $valid,
            'invalid_rows' => $invalid,
            'status' => 'completed'
        ]);

        return redirect()->route('admin.import-jobs.list')->with('success','File imported successfully');
    }

    public function destroy($id)
    {
        ImportJob::findOrFail($id)->delete();
        return redirect()->route('admin.import-jobs.list')
                         ->with('success','Import Job deleted successfully!');
    }

    public function show($id)
    {
        // ImportJob with admin relation
        $job = ImportJob::with('admin')->findOrFail($id);

        return view('admin.import-jobs.show', compact('job'));
    }
}
