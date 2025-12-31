@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Page Details</h3>
       <a href="{{ route('admin.pages.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mb-3"><strong>Title:</strong> {{ $page->title }}</div>
            <div class="mb-3"><strong>Slug:</strong> {{ $page->slug }}</div>
            <div class="mb-3"><strong>Meta Tags:</strong> {{ $page->meta_tags ?? '-' }}</div>
            <div class="mb-3"><strong>Content:</strong> {!! $page->content ?? '-' !!}</div>
            <div class="mb-3">
                <strong>Status:</strong>
                @if($page->status==1)
                    <span class="badge bg-success">Active</span>
                @else
                    <span class="badge bg-danger">Inactive</span>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection
