@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Fund List</h3>
        <a href="{{ route('admin.funds.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add New
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="text-uppercase">
                        <tr>
                            <th>SN.</th>
                            <th>Fund Name</th>
                            <th>Firm</th>
                            <th>Asset Class</th>
                            <th>Type</th>
                            <th>Strategy</th>
                            <th>Category</th>
                            <th>Risk Rating</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($funds as $fund)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $fund->fund_name }}</td>
                            <td>{{ $fund->firm->name ?? '-' }}</td>
                            <td>{{ $fund->assetClass->name ?? '-' }}</td>
                            <td>{{ $fund->type->name ?? '-' }}</td>
                            <td>{{ $fund->strategy->name ?? '-' }}</td>
                            <td>{{ $fund->category->name ?? '-' }}</td>
                            <td>{{ $fund->riskRating->name ?? '-' }}</td>
                            <td>
                                @if($fund->status == 1)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.funds.edit', $fund->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.funds.view', $fund->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       data-bs-toggle="tooltip"
                                       title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.funds.destroy', $fund->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No funds found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $funds->links('pagination::bootstrap-5') }}
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
