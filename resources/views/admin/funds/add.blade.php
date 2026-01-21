@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Add Fund</h3>
        <a href="{{ route('admin.funds.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.funds.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Fund DATA Key <span class="text-danger">*</span></label>
                        <input type="text" name="fundatakey" class="form-control" value="{{ old('fundatakey') }}">
                        @error('fundatakey') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Symbol Code</label>
                        <input type="text" name="symbol_code" class="form-control" value="{{ old('symbol_code') }}">
                        @error('symbol_code') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Fund Name <span class="text-danger">*</span></label>
                        <input type="text" name="fund_name" class="form-control" value="{{ old('fund_name') }}">
                        @error('fund_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Firm <span class="text-danger">*</span></label>
                        <select name="firm_id" class="form-select">
                            <option value="">Select Firm</option>
                            @foreach($firms as $firm)
                                <option value="{{ $firm->id }}" {{ old('firm_id') == $firm->id ? 'selected' : '' }}>{{ $firm->name }}</option>
                            @endforeach
                        </select>
                        @error('firm_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Asset Class <span class="text-danger">*</span></label>
                        <select name="asset_class_id" class="form-select">
                            <option value="">Select Asset Class</option>
                            @foreach($asset_classes as $ac)
                                <option value="{{ $ac->id }}" {{ old('asset_class_id') == $ac->id ? 'selected' : '' }}>{{ $ac->name }}</option>
                            @endforeach
                        </select>
                        @error('asset_class_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Type <span class="text-danger">*</span></label>
                        <select name="type_id" class="form-select">
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                         @error('type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Strategy <span class="text-danger">*</span></label>
                        <select name="strategy_id" class="form-select">
                            <option value="">Select Strategy</option>
                            @foreach($strategies as $strategy)
                                <option value="{{ $strategy->id }}" {{ old('strategy_id') == $strategy->id ? 'selected' : '' }}>{{ $strategy->name }}</option>
                            @endforeach
                        </select>
                         @error('strategy_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Risk Rating <span class="text-danger">*</span></label>
                        <select name="risk_rating_id" class="form-select">
                            <option value="">Select Risk Rating</option>
                            @foreach($risk_ratings as $rr)
                                <option value="{{ $rr->id }}" {{ old('risk_rating_id') == $rr->id ? 'selected' : '' }}>{{ $rr->name }}</option>
                            @endforeach
                        </select>
                        @error('risk_rating_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Fund AUM</label>
                        <input type="number" step="0.01" name="fund_aum" class="form-control" value="{{ old('fund_aum') }}">
                    </div>                    

                    <div class="col-md-4 mb-3">
                        <label>Fund Library Link</label>
                        <input type="url" name="fund_library_link" class="form-control" value="{{ old('fund_library_link') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>External Link</label>
                        <input type="url" name="external_link" class="form-control" value="{{ old('external_link') }}">
                    </div>

                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4 text-end">
                    <button class="btn btn-success">Submit</button>
                    <a href="{{ route('admin.funds.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
