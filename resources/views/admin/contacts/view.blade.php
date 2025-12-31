@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Contact Details</h3>
        <a href="{{ route('admin.contact.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="mb-3"><strong>First name:</strong> {{ $contact->fname }}</div>
            <div class="mb-3"><strong>Last name:</strong> {{ $contact->lname }}</div>
            <div class="mb-3"><strong>Mobile:</strong> {{ $contact->mobile }}</div>
            <div class="mb-3"><strong>Topic:</strong> {{ $contact->topic }}</div>
            <div class="mb-3"><strong>Email:</strong> {{ $contact->email }}</div>
            <div class="mb-3"><strong>Subject:</strong> {{ $contact->subject }}</div>   
            <div class="mb-3"><strong>Message:</strong> {{ $contact->message }}</div>              
        </div>
    </div>
</div>

@endsection
