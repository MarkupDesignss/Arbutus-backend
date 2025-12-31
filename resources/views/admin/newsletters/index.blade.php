@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">News Letters List</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">#</th>
                            <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Name</th>
                            <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Email</th>
                            <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($newsletters as $list)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $list->name }}</td>                               
                                <td>{{ $list->email }}</td>
                                
                                <td>
                                    <div class="d-flex gap-2">                                       
                                    <form action="{{ route('admin.newsletter-subscribe.destroy', $list->id) }}" method="POST"
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
                            <tr><td colspan="5" class="text-center">No newsletters found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">{{ $newsletters->links('pagination::bootstrap-5') }}</div>
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
