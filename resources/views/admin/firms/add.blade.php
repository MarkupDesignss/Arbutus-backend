@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Add Firm</h3>
        <a href="{{ route('admin.firms.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.firms.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               value="{{ old('name') }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Firm AUM</label>
                        <input type="number"
                               step="0.01"
                               class="form-control"
                               name="firm_aum"
                               value="{{ old('firm_aum') }}">
                        @error('firm_aum') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.firms.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
