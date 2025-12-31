@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">

    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="">
                
                <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 mb-4">
                            <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Admin Profile Update</h3>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="name">Name <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name', Auth::guard('admin')->user()->name) }}" placeholder="Enter name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="email">Email <span style="color:red;">*</span></label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ old('email', Auth::guard('admin')->user()->email) }}"
                                placeholder="Enter email">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="mobile">Mobile <span style="color:red;">*</span></label>
                            <input type="text" class="form-control" name="mobile" id="mobile"
                                value="{{ old('mobile', Auth::guard('admin')->user()->mobile) }}"
                                placeholder="Enter mobile">
                            @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" name="image" id="image"
                                accept=".jpg,.jpeg,.png,.svg">
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror

                            @if(Auth::guard('admin')->user()->image)
                            <img src="{{ asset('storage/' . Auth::guard('admin')->user()->image) }}" alt="Admin Image"
                                class="img-thumbnail" width="100">
                            @else
                            <img src="{{ asset('storage/default-image.jpg') }}" alt="Default Image" class="img-thumbnail"
                                width="100">
                            @endif
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="address">Address</label>
                            <textarea name="address" class="form-control" rows="2"
                                placeholder="Enter address">{{ old('address', Auth::guard('admin')->user()->address) }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-success">Update Profile</button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-danger ms-2">Cancel</a>
                    </div>
                </form>
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