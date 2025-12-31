@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Edit Fund</h3>
        <a href="{{ route('admin.funds.list') }}" class="btn btn-primary btn-custom-add">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.funds.update', $fund->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">

                    <!-- Fund ATA Key -->
                    <div class="col-md-4 mb-3">
                        <label>Fund DATA Key <span class="text-danger">*</span></label>
                        <input type="text" name="fundatakey" class="form-control" value="{{ old('fundatakey', $fund->fundatakey) }}">
                        @error('fundatakey') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Symbol Code -->
                    <div class="col-md-4 mb-3">
                        <label>Symbol Code</label>
                        <input type="text" name="symbol_code" class="form-control" value="{{ old('symbol_code', $fund->symbol_code) }}">
                    </div>

                    <!-- Fund Name -->
                    <div class="col-md-4 mb-3">
                        <label>Fund Name <span class="text-danger">*</span></label>
                        <input type="text" name="fund_name" class="form-control" value="{{ old('fund_name', $fund->fund_name) }}">
                        @error('fund_name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Firm -->
                    <div class="col-md-4 mb-3">
                        <label>Firm <span class="text-danger">*</span></label>
                        <select name="firm_id" class="form-select">
                            <option value="">Select Firm</option>
                            @foreach($firms as $firm)
                                <option value="{{ $firm->id }}" {{ old('firm_id', $fund->firm_id) == $firm->id ? 'selected' : '' }}>
                                    {{ $firm->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('firm_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Asset Class -->
                    <div class="col-md-4 mb-3">
                        <label>Asset Class <span class="text-danger">*</span></label>
                        <select name="asset_class_id" class="form-select">
                            <option value="">Select Asset Class</option>
                            @foreach($asset_classes as $ac)
                                <option value="{{ $ac->id }}" {{ old('asset_class_id', $fund->asset_class_id) == $ac->id ? 'selected' : '' }}>
                                    {{ $ac->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('asset_class_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Type -->
                    <div class="col-md-4 mb-3">
                        <label>Type <span class="text-danger">*</span></label>
                        <select name="type_id" class="form-select">
                            <option value="">Select Type</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id', $fund->type_id) == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('type_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Strategy -->
                    <div class="col-md-4 mb-3">
                        <label>Strategy <span class="text-danger">*</span></label>
                        <select name="strategy_id" class="form-select">
                            <option value="">Select Strategy</option>
                            @foreach($strategies as $strategy)
                                <option value="{{ $strategy->id }}" {{ old('strategy_id', $fund->strategy_id) == $strategy->id ? 'selected' : '' }}>
                                    {{ $strategy->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('strategy_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-4 mb-3">
                        <label>Category <span class="text-danger">*</span></label>
                        <select name="category_id" class="form-select">
                            <option value="">Select Category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $fund->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Risk Rating -->
                    <div class="col-md-4 mb-3">
                        <label>Risk Rating <span class="text-danger">*</span></label>
                        <select name="risk_rating_id" class="form-select">
                            <option value="">Select Risk Rating</option>
                            @foreach($risk_ratings as $rr)
                                <option value="{{ $rr->id }}" {{ old('risk_rating_id', $fund->risk_rating_id) == $rr->id ? 'selected' : '' }}>
                                    {{ $rr->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('risk_rating_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Fund AUM -->
                    <div class="col-md-4 mb-3">
                        <label>Fund AUM</label>
                        <input type="number" step="0.01" name="fund_aum" class="form-control" value="{{ old('fund_aum', $fund->fund_aum) }}">
                    </div>

                    <!-- One Month -->
                    <div class="col-md-4 mb-3">
                        <label>1 Month (%)</label>
                        <input type="number" step="0.01" name="one_month" class="form-control" value="{{ old('one_month', $fund->one_month) }}">
                    </div>

                    <!-- YTD -->
                    <div class="col-md-4 mb-3">
                        <label>YTD (%)</label>
                        <input type="number" step="0.01" name="ytd" class="form-control" value="{{ old('ytd', $fund->ytd) }}">
                    </div>

                    <!-- One Year -->
                    <div class="col-md-4 mb-3">
                        <label>1 Year (%)</label>
                        <input type="number" step="0.01" name="one_year" class="form-control" value="{{ old('one_year', $fund->one_year) }}">
                    </div>

                    <!-- Three Year -->
                    <div class="col-md-4 mb-3">
                        <label>3 Year (%)</label>
                        <input type="number" step="0.01" name="three_year" class="form-control" value="{{ old('three_year', $fund->three_year) }}">
                    </div>

                    <!-- Since Inception -->
                    <div class="col-md-4 mb-3">
                        <label>Since Inception (%)</label>
                        <input type="number" step="0.01" name="since_inception" class="form-control" value="{{ old('since_inception', $fund->since_inception) }}">
                    </div>

                    <!-- Three Year Std Dev -->
                    <div class="col-md-4 mb-3">
                        <label>3 Year Std Dev (%)</label>
                        <input type="number" step="0.01" name="three_year_std_dev" class="form-control" value="{{ old('three_year_std_dev', $fund->three_year_std_dev) }}">
                    </div>

                    <!-- Distribution Yield -->
                    <div class="col-md-4 mb-3">
                        <label>Distribution Yield (%)</label>
                        <input type="number" step="0.01" name="distribution_yield" class="form-control" value="{{ old('distribution_yield', $fund->distribution_yield) }}">
                    </div>

                    <!-- Inception Date -->
                    <div class="col-md-4 mb-3">
                        <label>Inception Date</label>
                        <input type="date" name="inception_date" class="form-control" value="{{ old('inception_date', $fund->inception_date) }}">
                    </div>

                    <!-- Fund Library Link -->
                    <div class="col-md-4 mb-3">
                        <label>Fund Library Link</label>
                        <input type="url" name="fund_library_link" class="form-control" value="{{ old('fund_library_link', $fund->fund_library_link) }}">
                    </div>

                    <!-- External Link -->
                    <div class="col-md-4 mb-3">
                        <label>External Link</label>
                        <input type="url" name="external_link" class="form-control" value="{{ old('external_link', $fund->external_link) }}">
                    </div>

                    <!-- Status -->
                    <div class="col-md-4 mb-3">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ old('status', $fund->status) == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('status', $fund->status) == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('admin.funds.list') }}" class="btn btn-danger ms-2">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>

@endsection
