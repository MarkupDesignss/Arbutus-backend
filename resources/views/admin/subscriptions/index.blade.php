@extends('admin.layouts.admin')
@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Subscription List</h3>
        <a href="{{ route('admin.subscriptions.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col" style="width: 50px;  background-color: #f1f5f9;">SN</th>
                        <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Name</th>
                        <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Monthly</th>
                        <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Yearly</th>
                        <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Popular</th>
                        <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Status</th>
                        <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptions as $sub)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sub->name }}</td>
                        <td>{{ $sub->monthly_price }}</td>
                        <td>{{ $sub->yearly_price }}</td>
                        <td>{!! $sub->is_popular ? '<span class="badge bg-warning">Yes</span>' : '<span
                                class="badge bg-danger">No</span>' !!}</td>
                        <td>{!! $sub->is_active ? '<span class="badge bg-success">Active</span>' : '<span
                                class="badge bg-danger">Inactive</span>' !!}</td>
                        <td>
                            <a href="{{ route('admin.subscriptions.edit',$sub->id) }}"
                                class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('admin.subscriptions.show',$sub->id) }}"
                                class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.subscriptions.destroy',$sub->id) }}" method="POST"
                                class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip"
                                    title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subscriptions->links('pagination::bootstrap-5') }}
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