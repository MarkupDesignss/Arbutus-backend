@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Pages List</h3>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>
    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">#</th>
                            <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Title</th>
                            <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Slug</th>
                            <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->slug }}</td>
                                <td>
                                    @if($page->status==1)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                                        <a href="{{ route('admin.pages.show', $page->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">No pages found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $pages->links('pagination::bootstrap-5') }}</div>
            </div>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let form = this.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to recover this Data!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53935',
            cancelButtonColor: '#9e9e9e',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endsection
