@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 class="mb-0 fw-bold text-primary" style="font-size:1.5rem;">Import Jobs List</h3>
        <a href="{{ route('admin.import-jobs.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="text-uppercase">
                    <tr>
                        <th>SN.</th>
                        <th>Admin</th>
                        <th>Original Filename</th>
                        <th>Stored Filename</th>
                        <th>Status</th>
                        <th>As Of Month</th>                        
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jobs as $job)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $job->admin->name ?? '' }}</td>
                        <td>{{ $job->original_filename }}</td>
                        <td>{{ $job->stored_filename }}</td>
                        <td>{{ ucfirst($job->status) }}</td>
                        <td>{{ $job->as_of_month }}</td>                        
                        <td>
                            <div class="d-flex gap-2">                               
                                <a href="{{ route('admin.import-jobs.show',$job->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="tooltip"
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                <form action="{{ route('admin.import-jobs.destroy',$job->id) }}" method="POST" class="delete-form">
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
                    <tr><td colspan="10" class="text-center">No Import Jobs found</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $jobs->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        let form = this.closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "You will not be able to recover this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53935',
            cancelButtonColor: '#9e9e9e',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!'
        }).then((result) => {
            if(result.isConfirmed) form.submit();
        });
    });
});
</script>

@endsection
