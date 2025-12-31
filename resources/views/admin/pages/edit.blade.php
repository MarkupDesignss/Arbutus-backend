@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Edit Page</h3>
        <a href="{{ route('admin.pages.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label>Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $page->title) }}" placeholder="Enter page title" id="title">
                    @error('title') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label>Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" id="slug" placeholder="Slug will auto-generate" readonly>
                    @error('slug') <small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="mb-3">
                    <label>Meta Tags</label>
                    <textarea name="meta_tags" class="form-control" rows="2">{{ old('meta_tags', $page->meta_tags) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Content</label>
                    <textarea name="content" class="form-control" rows="5">{{ old('content', $page->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label>Status</label>
                    <select name="status" class="form-select">
                        <option value="1" {{ $page->status==1?'selected':'' }}>Active</option>
                        <option value="0" {{ $page->status==0?'selected':'' }}>Inactive</option>
                    </select>
                </div>

                <div class="text-end">
                    <button class="btn btn-success">Update</button>
                    <a href="{{ route('admin.pages.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');

    titleInput.addEventListener('input', function() {
        let slug = this.value.toLowerCase()
                             .trim()
                             .replace(/\s+/g, '_')
                             .replace(/[^\w\-]+/g, '');
        slugInput.value = slug;
    });
</script>

@endsection
