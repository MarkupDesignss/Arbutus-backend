@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
     <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Blog Details</h3>
        <a href="{{ route('admin.blog.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Title:</div>
                <div class="col-md-9">{{ $blog->title }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Slug:</div>
                <div class="col-md-9">{{ $blog->slug }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Author:</div>
                <div class="col-md-9">{{ $blog->author_name }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Post Date:</div>
                <div class="col-md-9">{{ date('d M Y',strtotime($blog->post_date)) }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Status:</div>
                <div class="col-md-9">
                    @if($blog->status)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-danger">Inactive</span>
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Short Description:</div>
                <div class="col-md-9">{{ $blog->short_description }}</div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 fw-bold">Long Description:</div>
                <div class="col-md-9">{!! nl2br($blog->long_description) !!}</div>
            </div>

            <div class="row">
                <div class="col-md-3 fw-bold">Image:</div>
                <div class="col-md-9">
                    <img src="{{ asset('storage/blogs/'.$blog->image) }}" width="60" class="rounded shadow">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
