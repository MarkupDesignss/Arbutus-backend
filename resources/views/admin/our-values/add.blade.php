@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">    
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Add our value</h3>
        <a href="{{ route('admin.value.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.value.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="title">Title</label><span style="color:red;">*</span>
                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}"
                            placeholder="Enter title">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="image">Image</label><span style="color:red;">*</span>
                        <input type="file" class="form-control" name="image" id="image" accept=".jpg,.jpeg,.png,.webp">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    
                    <div class="col-md-4 mb-3">
                        <label for="status">Status</label>
                        <select class="form-select" name="status" id="status">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="short_description">Short Description</label><span style="color:red;">*</span>
                        <textarea class="form-control" name="short_description" id="short_description" rows="4"
                            placeholder="Enter Short description">{{ old('short_description') }}</textarea>
                        @error('short_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="long_description">Long Description</label>
                        <textarea class="form-control" name="long_description" id="long_description" rows="4"
                            placeholder="Enter long description">{{ old('long_description') }}</textarea>
                        @error('long_description') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.value.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection