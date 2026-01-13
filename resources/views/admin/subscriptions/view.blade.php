@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">View Subscription</h3>
        <a href="{{ route('admin.subscriptions.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="row">

                <!-- Name -->
                <div class="col-md-6 mb-3">
                    <strong>Name:</strong>
                    <p>{{ $subscription->name }}</p>
                </div>

                <!-- Title -->
                <div class="col-md-6 mb-3">
                    <strong>Title:</strong>
                    <p>{{ $subscription->title ?? '-' }}</p>
                </div>

                <!-- Monthly Price -->
                <div class="col-md-6 mb-3">
                    <strong>Monthly Price:</strong>
                    <p>{{ number_format($subscription->monthly_price, 2) }}</p>
                </div>

                <!-- Yearly Price -->
                <div class="col-md-6 mb-3">
                    <strong>Yearly Price:</strong>
                    <p>{{ number_format($subscription->yearly_price, 2) }}</p>
                </div>

                <!-- Popular -->
                <div class="col-md-6 mb-3">
                    <strong>Popular:</strong>
                    <p>{{ $subscription->is_popular ? 'Yes' : 'No' }}</p>
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <strong>Status:</strong>
                    <p>{{ $subscription->is_active ? 'Active' : 'Inactive' }}</p>
                </div>

                <!-- Features -->
                <div class="col-md-12 mb-3">
                    <strong>Features:</strong>
                    @if(count($subscription->features) > 0)
                        <ul>
                            @foreach($subscription->features as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>-</p>
                    @endif
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
