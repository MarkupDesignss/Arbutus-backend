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
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ImportJobController extends Controller
{
    public function index()
    {
        $data['jobs'] = ImportJob::with('admin')->orderBy('id', 'desc')->paginate(10);
        return view('admin.import-jobs.index', $data);
    }

    public function create()
    {
        $data['admins'] = Admin::where('status', 1)->get();
        return view('admin.import-jobs.add', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'admin_id'    => 'required|exists:admins,id',
            'csv_file'    => 'required|mimes:csv,xlsx,xls',
            'status'      => 'nullable|string',
            'as_of_month' => 'required',
        ]);

        $asOfMonth = $request->as_of_month . '-01';
        $file = $request->file('csv_file');
        $originalName = $file->getClientOriginalName();
        $storedName = time() . '_' . $originalName;
        $path = $file->storeAs('import_jobs', $storedName, 'public');

        // Create Import Job with initial status
       $job = ImportJob::create([
            'admin_id' => $request->admin_id,
            'original_filename' => $originalName,
            'stored_filename' => $storedName,
            'status' => 'uploaded',
            'as_of_month' => $asOfMonth,
        ]);

        // Jab validation start ho
        $job->update(['status' => 'validating']);

        // Agar validation fail ho gaya
        $job->update(['status' => 'failed']);

        // Agar validation pass ho gaya
        $job->update(['status' => 'validated']);

        // Jab data main table me save ho raha ho
        $job->update(['status' => 'processing']);

        // Jab sab complete ho gaya
        $job->update(['status' => 'completed']);

        // Read Excel rows
        $rows = Excel::toArray([], storage_path('app/public/' . $path))[0];

        $total = $valid = $invalid = 0;
        $missingFunds = [];
        $invalidRowsSample = [];
        $insertJobRows = [];
        $insertMonthlyReturns = [];

        DB::transaction(function() use($rows, $job, &$total, &$valid, &$invalid, &$missingFunds, &$invalidRowsSample, &$insertJobRows, &$insertMonthlyReturns) {
            foreach ($rows as $i => $row) {
                if ($i == 0) continue;
                $total++;

                $fundatakey = $row[0] ?? null;

                // Date parsing
                $month_end = null;
                if(isset($row[1]) && $row[1] != '') {
                    // Try d-m-Y string
                    try {
                        $month_end = Carbon::createFromFormat('d-m-Y', $row[1])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Try Excel numeric
                        if(is_numeric($row[1])) {
                            $month_end = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])->format('Y-m-d');
                        }
                    }
                }

                // Monthly return
                $monthly_return = isset($row[2]) ? floatval($row[2]) : null;

                // Distribution yield
                $distribution_yield = null;

                if(isset($row[3]) && $row[3] !== '') {
                 $val = $row[3]; // Excel cell
                    if(is_numeric($val) && $val < 1) {
                        $distribution_yield = round($val * 100, 2); // 0.04 -> 4.00
                    } else {
                        $distribution_yield = round(floatval(str_replace('%','',$val)), 2);
                    }
                }

                // Check fund exists
                $fund = $fundatakey ? Fund::where('fundatakey', $fundatakey)->first() : null;
                $isValid = $fundatakey && $month_end && $monthly_return !== null && $fund && $distribution_yield !== null;

                if (!$fund) {
                    $missingFunds[] = $fundatakey;
                }

               if (!$isValid) {
                    $invalidRowsSample[] = [
                        'fundatakey' => $fundatakey,
                        'month_end' => $month_end ? Carbon::parse($month_end)->format('Y-m-d') : null,
                        'monthly_return' => $monthly_return,
                        'distribution_yield' => $distribution_yield,
                    ];
                }


                // Prepare ImportJobRow insert
                $insertJobRows[] = [
                    'import_job_id' => $job->id,
                    'fundatakey' => $fundatakey,
                    'month_end' => $month_end,
                    'monthly_return' => $monthly_return,
                    'distribution_yield' => $distribution_yield,
                    'is_valid' => $isValid,
                    'errors' => $isValid ? null : json_encode(['Invalid data or fund not found']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

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

            // Bulk insert job rows
            ImportJobRow::insert($insertJobRows);

            // Bulk insert or update FundMonthlyReturn
            foreach ($insertMonthlyReturns as $data) {
                FundMonthlyReturn::updateOrCreate(
                    ['fund_id' => $data['fund_id'], 'month_end' => $data['month_end']],
                    ['monthly_return' => $data['monthly_return'], 'distribution_yield' => $data['distribution_yield']]
                );
            }

            // Update job summary
            $job->update([
                'total_rows' => $total,
                'valid_rows' => $valid,
                'invalid_rows' => $invalid,
                'summary' => json_encode([
                    'missing_funds' => $missingFunds,
                    'invalid_rows_sample' => $invalidRowsSample,
                    'coverage_percentage' => $total ? round(($valid/$total)*100,2) : 0
                ]),
                'status' => 'completed'
            ]);
        });

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
        $job = ImportJob::with('admin')->findOrFail($id);
        return view('admin.import-jobs.show', compact('job'));
    }
}