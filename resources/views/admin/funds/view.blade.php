@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Fund Details</h3>
        <a href="{{ route('admin.funds.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Fund Overview</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>Fund DATA Key:</strong>
                    <p class="text-muted">{{ $fund->fundatakey }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Symbol Code:</strong>
                    <p class="text-muted">{{ $fund->symbol_code ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Fund Name:</strong>
                    <p class="text-muted">{{ $fund->fund_name }}</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>Firm:</strong>
                    <p class="text-muted">{{ $fund->firm->name ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Asset Class:</strong>
                    <p class="text-muted">{{ $fund->assetClass->name ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Type:</strong>
                    <p class="text-muted">{{ $fund->type->name ?? '-' }}</p>
                </div>
            </div>

            <div class="row g-3 mb-4">
                <div class="col-md-4">
                    <strong>Strategy:</strong>
                    <p class="text-muted">{{ $fund->strategy->name ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Category:</strong>
                    <p class="text-muted">{{ $fund->category->name ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <strong>Risk Rating:</strong>
                    <p class="text-muted">{{ $fund->riskRating->name ?? '-' }}</p>
                </div>
            </div>

            <!-- Performance Metrics -->
            <div class="card mb-4">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">Performance Metrics (%)</h6>
                </div>                
            </div>

            <!-- Links & Status -->
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <strong>Fund Library:</strong>
                    @if($fund->fund_library_link)
                        <p><a href="{{ $fund->fund_library_link }}" target="_blank" class="link-primary">{{ $fund->fund_library_link }}</a></p>
                    @else
                        <p>-</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>External Link:</strong>
                    @if($fund->external_link)
                        <p><a href="{{ $fund->external_link }}" target="_blank" class="link-primary">{{ $fund->external_link }}</a></p>
                    @else
                        <p>-</p>
                    @endif
                </div>
                <div class="col-md-4">
                    <strong>Status:</strong>
                    @if($fund->status == 1)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
