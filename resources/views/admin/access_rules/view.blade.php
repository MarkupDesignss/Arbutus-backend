@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Access Rule Details</h3>
        <a href="{{ route('admin.access.rule.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Module</th>
                    <td>{{ $access_rule->module }}</td>
                </tr>
                <tr>
                    <th>Rule Type</th>
                    <td><span class="badge bg-info">{{ ucfirst($access_rule->rule_type) }}</span></td>
                </tr>
                <tr>
                    <th>Rule Key</th>
                    <td>{{ $access_rule->rule_key }}</td>
                </tr>
                <tr>
                    <th>Label</th>
                    <td>{{ $access_rule->label }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        {!! $access_rule->status ? '<span class="badge bg-success">Active</span>' :
                        '<span class="badge bg-danger">Inactive</span>' !!}
                    </td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $access_rule->created_at->format('d M Y h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection
