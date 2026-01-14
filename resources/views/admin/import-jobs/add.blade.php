@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold text-primary" style="font-size:1.5rem;">Add Import Job</h3>
        <a href="{{ route('admin.import-jobs.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.import-jobs.store') }}" method="POST" enctype="multipart/form-data">

                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Admin</label>
                        <select name="admin_id" class="form-select">
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ old('admin_id')==$admin->id?'selected':'' }}>
                                {{ $admin->name }}</option>
                            @endforeach
                        </select>
                        @error('admin_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Upload File (CSV / Excel)</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv,.xlsx,.xls" required>
                        @error('csv_file') <small class="text-danger">{{ $message }}</small> @enderror

                        <div class="mt-2">
                            <a href="{{ route('admin.import-jobs.sample-download') }}"
                                class="text-decoration-none small fw-semibold text-primary">
                                <i class="bi bi-download me-1"></i> Download Sample Excel
                            </a>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            @foreach(['uploaded','validating','failed','validated','processing','completed'] as $status)
                            <option value="{{ $status }}" {{ old('status')==$status?'selected':'' }}>
                                {{ ucfirst($status) }}</option>
                            @endforeach
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>As Of Month</label>
                        <input type="month" class="form-control" name="as_of_month" value="{{ old('as_of_month') }}">
                        @error('as_of_month') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Save</button>
                    <a href="{{ route('admin.import-jobs.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection