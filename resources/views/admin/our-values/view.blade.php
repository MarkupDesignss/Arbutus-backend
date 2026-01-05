@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
     <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Our Value Details</h3>
        <a href="{{ route('admin.value.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Title:</div>
                <div class="col-md-9">{{ $value->title }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status:</div>
                <div class="col-md-9">
                    @if($value->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Short Description:</div>
                <div class="col-md-9">{{ $value->short_description }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Long Description:</div>
                <div class="col-md-9">{!! nl2br($value->long_description) !!}</div>
            </div>

            <div class="row">
                <div class="col-md-3 fw-bold">Image:</div>
                <div class="col-md-9">
                    <img src="{{ asset('storage/values/'.$value->image) }}" width="60" class="rounded shadow">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
