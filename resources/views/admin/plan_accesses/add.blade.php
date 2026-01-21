@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="fw-bold">Add Plan Access</h3>
        <a href="{{ route('admin.plan.access.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left"></i> Back
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.plan.access.store') }}">
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Subscription</label>
                        <select name="subscription_id" class="form-select">
                            @foreach($subscriptions as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Access Rule</label>
                        <select name="access_rule_id" class="form-select">
                            @foreach($access_rules as $r)
                                <option value="{{ $r->id }}">{{ $r->label }} ({{ $r->module }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="mt-3 text-end">
                    <button class="btn btn-success">Save Mapping</button>
                    <a href="{{ route('admin.plan.access.list') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
