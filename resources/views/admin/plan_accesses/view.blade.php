@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Plan Access Details</h3>
        <a href="{{ route('admin.plan.access.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Subscription</th>
                    <td>{{ $plan_access->subscription->name ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Access Rule</th>
                    <td>{{ $plan_access->accessRule->label ?? '-' }} ({{ $plan_access->accessRule->module ?? '-' }})</td>
                </tr>
                <tr>
                    <th>Rule Type</th>
                    <td><span class="badge bg-info">{{ ucfirst($plan_access->accessRule->rule_type ?? '-') }}</span></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>{!! $plan_access->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $plan_access->created_at->format('d M Y h:i A') }}</td>
                </tr>
                <tr>
                    <th>Updated At</th>
                    <td>{{ $plan_access->updated_at->format('d M Y h:i A') }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>

@endsection
