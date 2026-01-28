@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <!-- <h3 class="mb-0 fw-bold">Asset Class List</h3> -->
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Sponsors List</h3>
        <a href="{{ route('admin.sponsors.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">SN.</th>                            
                            <th scope="col" style="width: 250px; background-color: #f1f5f9;">Image</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Status</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sponsors as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>                            
                            <td>
                                <img src="{{ asset('storage/sponsors/'.$list->image) }}" class="rounded border"
                                    width="80">
                            </td>
                            <td>
                                @if($list->status == 1)
                                <span class="badge bg-success">Active</span>
                                @else
                                <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.sponsors.edit',$list->id) }}"
                                        class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.sponsors.destroy',$list->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No sponsors found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $sponsors->links('pagination::bootstrap-5') }}
                </div>
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