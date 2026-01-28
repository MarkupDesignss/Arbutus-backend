@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Edit Blog</h3>
        <a href="{{ route('admin.blog.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.blog.update',$blog->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Title</label><span class="text-danger">*</span>
                        <input type="text" name="title" id="title" value="{{ old('title',$blog->title) }}" class="form-control">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Slug</label><span class="text-danger">*</span>
                        <input type="text" name="slug" id="slug" value="{{ old('slug',$blog->slug) }}" readonly class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Image</label>
                        <input type="file" name="image" class="form-control">
                        @if($blog->image)
                            <img src="{{ asset('storage/blogs/'.$blog->image) }}" class="mt-2 rounded" width="70">
                        @endif
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Post Date</label>
                        <input type="date" name="post_date" value="{{ old('post_date',$blog->post_date) }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Author Name</label>
                        <input type="text" name="author_name" value="{{ old('author_name',$blog->author_name) }}" class="form-control">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $blog->status==1?'selected':'' }}>Active</option>
                            <option value="0" {{ $blog->status==0?'selected':'' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- ===== NEW FIELD: TYPE ===== -->
                    <div class="col-md-4 mb-3">
                        <label>Type</label><span class="text-danger">*</span>
                        <select name="type" class="form-select">
                            <option value="news" {{ old('type',$blog->type)=='news' ? 'selected' : '' }}>News</option>
                            <option value="education" {{ old('type',$blog->type)=='education' ? 'selected' : '' }}>Education</option>
                        </select>
                        @error('type') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- ===== NEW FIELD: VIDEO URL ===== -->
                    <div class="col-md-8 mb-3">
                        <label>Video URL</label>
                        <input type="text" name="video_url" class="form-control" value="{{ old('video_url',$blog->video_url) }}" placeholder="Enter video URL">
                        @error('video_url') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- ===== NEW FIELDS END ===== -->

                    <div class="col-md-12 mb-3">
                        <label>Short Description</label>
                        <textarea name="short_description" class="form-control" rows="3">{{ old('short_description',$blog->short_description) }}</textarea>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label>Long Description</label>
                        <textarea name="long_description" class="form-control" rows="4">{{ old('long_description',$blog->long_description) }}</textarea>
                    </div>

                </div>

                <div class="text-end mt-3">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('admin.blog.list') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('title').addEventListener('keyup', function() {
    let slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/(^-|-$)/g,'');
    document.getElementById('slug').value = slug;
});
</script>
@endsection
