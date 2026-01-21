@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size:1.5rem;color:#0d6efd;" class="mb-0 fw-bold">Add Subscription</h3>
        <a href="{{ route('admin.subscriptions.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.subscriptions.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Name -->
                    <div class="col-md-4 mb-3">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Enter name">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Title -->
                    <div class="col-md-4 mb-3">
                        <label>Title</label>
                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Enter title">
                        @error('title') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Monthly Price -->
                    <div class="col-md-4 mb-3">
                        <label>Monthly Price</label>
                        <input type="number" step="0.01" class="form-control" name="monthly_price" value="{{ old('monthly_price') }}" placeholder="Enter monthly price">
                        @error('monthly_price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Yearly Price -->
                    <div class="col-md-4 mb-3">
                        <label>Yearly Price</label>
                        <input type="number" step="0.01" class="form-control" name="yearly_price" value="{{ old('yearly_price') }}" placeholder="Enter yearly price">
                        @error('yearly_price') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Popular -->
                    <div class="col-md-4 mb-3">
                        <label>Popular</label>
                        <select class="form-select" name="is_popular">
                            <option value="0" {{ old('is_popular') == '0' ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('is_popular') == '1' ? 'selected' : '' }}>Yes</option>
                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select class="form-select" name="is_active">
                            <option value="1" {{ old('is_active') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Features Dynamic Fields -->
                    <div class="col-md-12 mb-3">
                        <label>Features</label>
                        <div id="features_wrapper" class="d-flex flex-column gap-2">
                            @if(old('features'))
                                @foreach(old('features') as $feature)
                                    <div class="input-group feature_row" style="width:50%;">
                                        <input type="text" name="features[]" class="form-control" value="{{ $feature }}" placeholder="Enter feature">
                                        <span class="feature_buttons"></span>
                                    </div>
                                @endforeach
                            @else
                                <div class="input-group feature_row" style="width:50%;">
                                    <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                                    <span class="feature_buttons"></span>
                                </div>
                            @endif
                        </div>
                        <small class="text-muted">Max 5 features allowed</small>
                        @error('features') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.subscriptions.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Feature Add/Delete JS -->
<script>
    const max_features = 5;
    const wrapper = document.getElementById('features_wrapper');

    function updateButtons() {
        const rows = wrapper.querySelectorAll('.feature_row');

        rows.forEach((row, index) => {
            const buttons = row.querySelector('.feature_buttons');
            buttons.innerHTML = '';

            // First row always has Add button
            if (index === 0) {
                buttons.innerHTML += `
                    <button type="button" class="btn btn-success add_feature me-1">
                        <i class="bi bi-plus"></i>
                    </button>
                `;
            }

            // Delete button for all rows if more than 1 exists
            if (rows.length > 1) {
                buttons.innerHTML += `
                    <button type="button" class="btn btn-danger remove_feature">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
            }
        });
    }

    wrapper.addEventListener('click', function(e){
        // Add new feature
        if (e.target.closest('.add_feature')) {
            const count = wrapper.querySelectorAll('.feature_row').length;
            if(count >= max_features){
                alert("Maximum 5 features allowed");
                return;
            }

            const div = document.createElement('div');
            div.classList.add('input-group', 'feature_row');
            div.style.width = '50%';
            div.style.marginTop = '5px';

            div.innerHTML = `
                <input type="text" name="features[]" class="form-control" placeholder="Enter feature">
                <span class="feature_buttons"></span>
            `;

            wrapper.appendChild(div);
            updateButtons();
        }

        // Remove feature
        if (e.target.closest('.remove_feature')) {
            e.target.closest('.feature_row').remove();
            updateButtons();
        }
    });

    // Initial render
    updateButtons();
</script>

@endsection
