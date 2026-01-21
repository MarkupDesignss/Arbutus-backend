@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Access Rules</h3>
        <a href="{{ route('admin.access.rule.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 50px;  background-color: #f1f5f9;">#</th>
                    <th scope="col" style="width: 170px;  background-color: #f1f5f9;">Module</th>
                    <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Rule Type</th>
                    <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Rule Key</th>
                    <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Status</th>
                    <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($access_rules as $rule)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $rule->module }}</td>
                        <td><span class="badge bg-info">{{ ucfirst($rule->rule_type) }}</span></td>
                        <td>{{ $rule->rule_key }}</td>
                        <td>
                            {!! $rule->status ? '<span class="badge bg-success">Active</span>' :
                            '<span class="badge bg-danger">Inactive</span>' !!}
                        </td>
                        <td>
                            <a href="{{ route('admin.access.rule.edit',$rule->id) }}"
                               class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('admin.access.rule.show',$rule->id) }}"
                               class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('admin.access.rule.destroy',$rule->id) }}"
                                  method="POST" class="d-inline delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $access_rules->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        let form = this.closest('form');

        Swal.fire({
            title: 'Are you sure?',
            text: "This rule will be permanently deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53935',
            cancelButtonColor: '#9e9e9e',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endsection
