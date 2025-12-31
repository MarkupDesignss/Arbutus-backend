@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold text-primary" style="font-size:1.5rem;">View Banner</h3>
        <a href="{{ route('admin.banner.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Title:</label>
                    <div class="form-control bg-light">{{ $banner->title ?? '-' }}</div>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Status:</label>
                    <div class="form-control bg-light">
                        @if($banner->status==1)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label class="fw-bold">Created At:</label>
                    <div class="form-control bg-light">{{ $banner->created_at->format('d M Y') }}</div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Description:</label>
                    <div class="form-control bg-light" style="min-height:100px;">
                        {{ $banner->description ?? '-' }}
                    </div>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="fw-bold">Banner Image:</label><br>
                    @if($banner->image)
                        <img src="{{ asset('storage/banners/'.$banner->image) }}" class="img-fluid rounded shadow" style="max-height:100px;">
                    @else
                        <span class="text-muted">No image uploaded</span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
