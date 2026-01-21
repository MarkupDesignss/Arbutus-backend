@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Plan Access Mapping</h3>
        <a href="{{ route('admin.plan.access.create') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-plus-circle me-1"></i>Add Mapping
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col" style="width: 50px;  background-color: #f1f5f9;">#</th>
                    <th scope="col" style="width: 100px;  background-color: #f1f5f9;">Subscription</th>
                    <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Access Rule</th>
                    <th scope="col" style="width: 150px;  background-color: #f1f5f9;">Type</th>
                    <th scope="col" style="width: 50px;  background-color: #f1f5f9;">Status</th>
                    <th scope="col" style="width: 200px;  background-color: #f1f5f9;">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($plan_accesses as $pa)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $pa->subscription->name }}</td>
                    <td>{{ $pa->accessRule->label }}</td>
                    <td><span class="badge bg-info">{{ ucfirst($pa->accessRule->rule_type) }}</span></td>
                    <td>{!! $pa->status ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Inactive</span>' !!}</td>
                    <td>
                        <a href="{{ route('admin.plan.access.edit',$pa->id) }}" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                        <a href="{{ route('admin.plan.access.show',$pa->id) }}" class="btn btn-sm btn-outline-info"><i class="fas fa-eye"></i></a>
                        <form action="{{ route('admin.plan.access.destroy',$pa->id) }}" method="POST" class="d-inline delete-form">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {{ $plan_accesses->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.delete-btn').forEach(btn=>{
    btn.addEventListener('click',function(e){
        e.preventDefault();
        let form=this.closest('form');
        Swal.fire({
            title:'Delete Mapping?',
            text:'This feature will be removed from plan!',
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#e53935',
            confirmButtonText:'Yes delete'
        }).then(r=>{ if(r.isConfirmed) form.submit(); });
    });
});
</script>
@endsection
