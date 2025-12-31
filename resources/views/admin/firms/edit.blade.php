@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Edit Firm</h3>
        <a href="{{ route('admin.firms.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.firms.update', $firm->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label for="name">Name <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               name="name"
                               id="name"
                               value="{{ old('name', $firm->name) }}"
                               placeholder="Enter firm name">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Firm AUM -->
                    <div class="col-md-4 mb-3">
                        <label for="firm_aum">Firm AUM</label>
                        <input type="number"
                               step="0.01"
                               class="form-control"
                               name="firm_aum"
                               id="firm_aum"
                               value="{{ old('firm_aum', $firm->firm_aum) }}"
                               placeholder="Enter firm AUM">
                        @error('firm_aum')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="1" {{ old('status', $firm->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $firm->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">
                        Update
                    </button>
                    <a href="{{ route('admin.firms.list') }}" class="btn btn-danger ms-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
