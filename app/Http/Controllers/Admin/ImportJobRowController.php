<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ImportJobRow;
use App\Models\ImportJob;

class ImportJobRowController extends Controller
{
    public function index()
    {
        $data['rows'] = ImportJobRow::with('importJob')->orderBy('id','desc')->paginate(10);
        return view('admin.import-job-rows.index',$data);
    }

    public function show($id)
    {
        $data['job'] = ImportJob::with('rows')->findOrFail($id);
        return view('admin.import-job-rows.show',$data);
    }
}

