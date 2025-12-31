@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Edit User</h3>
        <a href="{{ route('admin.users.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.users.update',$user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Name</label><span class="text-danger">*</span>
                        <input type="text" class="form-control" name="name" value="{{ old('name',$user->name) }}">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Email</label><span class="text-danger">*</span>
                        <input type="email" class="form-control" name="email" value="{{ old('email',$user->email) }}">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Mobile</label>
                        <input type="text" class="form-control" name="mobile" value="{{ old('mobile',$user->mobile) }}">
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" placeholder="Leave blank to keep current">
                        @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role">
                            <option value="administrator" {{ $user->role=='administrator'?'selected':'' }}>Administrator</option>
                            <option value="data_manager" {{ $user->role=='data_manager'?'selected':'' }}>Data Manager</option>
                            <option value="read_only" {{ $user->role=='read_only'?'selected':'' }}>Read Only</option>
                        </select>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ $user->status==1?'selected':'' }}>Active</option>
                            <option value="0" {{ $user->status==0?'selected':'' }}>Inactive</option>
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
                            <input type="checkbox" name="permissions[]" value="{{ $p }}"
                            {{ in_array($p,$permissions ?? []) ? 'checked' : '' }}> {{ $p }}
                        </label>
                        @endforeach
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.users.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
