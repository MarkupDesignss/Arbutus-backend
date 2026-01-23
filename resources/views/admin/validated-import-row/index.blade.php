@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <!-- <h3 class="mb-0 fw-bold">Asset Class List</h3> -->
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Validated Import Job Row List</h3>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">            
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead class="text-uppercase">
                        <tr>
                            <th scope="col" style="width: 50px;  background-color: #f1f5f9;">SN.</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Fund Name</th>                           
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Fundata Key</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Month End</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Monthly Return</th>
                            <th scope="col" style="width: 200px; background-color: #f1f5f9;">Distribution Yield</th>
                            <!-- <th scope="col" style="width: 200px; background-color: #f1f5f9;">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $list)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $list->fund->fund_name ?? 'N/A' }}</td>                            
                            <td>{{ $list->fundatakey  }}</td>
                            <td>{{ $list->month_end  }}</td>
                            <td>{{ $list->monthly_return  }}</td>
                            <td>{{ $list->distribution_yield  }}%</td>                            

                            <!-- <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <form action="{{ route('admin.validated-import-row.destroy', $list->id) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-outline-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td> -->
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No asset classes found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $rows->links('pagination::bootstrap-5') }}
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