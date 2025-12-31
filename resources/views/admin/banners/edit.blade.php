@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="mb-0 fw-bold text-primary" style="font-size:1.5rem;">Edit Banner</h3>
        <a href="{{ route('admin.banner.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.banner.update',$banner->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title',$banner->title) }}">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Change Image</label>
                        <input type="file" class="form-control" name="image" accept=".jpg,.jpeg,.png,.webp">
                        @error('image') <small class="text-danger">{{ $message }}</small> @enderror

                        @if($banner->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/banners/'.$banner->image) }}" width="140"
                                class="rounded border">
                        </div>
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="status">
                            <option value="1" {{ $banner->status==1?'selected':'' }}>Active</option>
                            <option value="0" {{ $banner->status==0?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Description</label>
                        <textarea class="form-control" rows="4"
                            name="description">{{ old('description',$banner->description) }}</textarea>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('admin.banner.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection