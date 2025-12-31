@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Add User</h3>
        <a href="{{ route('admin.users.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Email</label><span class="text-danger">*</span>
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="mobile"
                            value="{{ old('mobile', $user->mobile ?? '') }}" placeholder="Enter mobile number">
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>


                    <div class="col-md-4 mb-3">
                        <label>Password</label><span class="text-danger">*</span>
                        <input type="password" class="form-control" name="password">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="administrator">Administrator</option>
                            <option value="data_manager">Data Manager</option>
                            <option value="read_only">Read Only</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Permissions</label><br>
                        @php
                        $perms = [
                        'dashboard.view','users.create','users.edit','users.delete',
                        'products.view','orders.view','cms.manage'
                        ];
                        @endphp

                        @foreach($perms as $p)
                        <label class="me-3">
                            <input type="checkbox" name="permissions[]" value="{{ $p }}"> {{ $p }}
                        </label>
                        @endforeach
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.users.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection