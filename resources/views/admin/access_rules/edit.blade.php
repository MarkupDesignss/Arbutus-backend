@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Edit Access Rule</h3>
        <a href="{{ route('admin.access.rule.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.access.rule.update',$access_rule->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Module<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="module"
                               value="{{ old('module',$access_rule->module) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Rule Type</label>
                        <select name="rule_type" class="form-select">
                            @foreach(['column','filter','feature'] as $type)
                                <option value="{{ $type }}" {{ $access_rule->rule_type == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Rule Key<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="rule_key"
                               value="{{ old('rule_key',$access_rule->rule_key) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Label<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="label"
                               value="{{ old('label',$access_rule->label) }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ $access_rule->status ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ !$access_rule->status ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('admin.access.rule.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
