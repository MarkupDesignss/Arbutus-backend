@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Add Access Rule</h3>
        <a href="{{ route('admin.access.rule.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.access.rule.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Module -->
                    <div class="col-md-4 mb-3">
                        <label>Module <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="module" value="{{ old('module') }}" placeholder="eg: products, bookings, reports">
                        @error('module') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Rule Type -->
                    <div class="col-md-4 mb-3">
                        <label>Rule Type</label>
                        <select name="rule_type" class="form-select">
                            <option value="column">Column</option>
                            <option value="filter">Filter</option>
                            <option value="feature">Feature</option>
                        </select>
                        @error('rule_type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Rule Key -->
                    <div class="col-md-4 mb-3">
                        <label>Rule Key<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="rule_key" value="{{ old('rule_key') }}" placeholder="eg: price, status, export_csv">
                        @error('rule_key') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Label -->
                    <div class="col-md-4 mb-3">
                        <label>Label<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="label" value="{{ old('label') }}" placeholder="eg: Product Price Column">
                        @error('label') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.access.rule.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
