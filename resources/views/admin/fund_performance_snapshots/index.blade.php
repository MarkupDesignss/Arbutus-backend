@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">
            Fund Performance Snapshots
        </h3>
    </div>

    {{-- Filter Card --}}
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="snapshot-form" method="POST" action="{{ route('admin.fund.performance.store') }}">
                @csrf
                <div class="row align-items-end">
                    {{-- Fund --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Fund</label>
                        <select id="fund-select" name="fund_id" class="form-select">
                            <option value="">-- Select Fund --</option>
                            @foreach($fundOptions as $opt)
                                <option value="{{ $opt->fund_id }}">
                                    {{ optional($opt->fund)->fund_name ?? 'Unknown' }} - {{ $opt->fundatakey }}
                                </option>
                            @endforeach
                            @error('fund_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </select>
                    </div>

                    {{-- As Of Month --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">As Of Month</label>
                        <select id="month-select" name="as_of_month" class="form-select">
                            <option value="">-- Select Month --</option>
                        </select>
                    </div>

                    {{-- Button --}}
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-success w-100">
                            Calculate
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Listing Section --}}
    <div class="card shadow-sm">
        <div class="card-body">

            <h3 class="mb-3 fw-semibold"  style="color: #0d6efd;">Snapshots List</h3>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-uppercase">
                        <tr>
                            <th>Fund</th>
                            <th>As Of Month</th>
                            <th>1 Month</th>
                            <th>YTD</th>
                            <th>1 Year</th>
                            <th>3 Year</th>
                            <th>Since Inception</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($snapshots as $s)
                            <tr>
                                <td>{{ optional($s->fund)->fund_name }}</td>
                                <td>{{ $s->as_of_month }}</td>
                                <td>{{ $s->one_month }}</td>
                                <td>{{ $s->ytd }}</td>
                                <td>{{ $s->one_year }}</td>
                                <td>{{ $s->three_year }}</td>
                                <td>{{ $s->since_inception }}</td>
                                <td>
                                    <span class="badge {{ $s->is_published ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $s->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">
                                    No snapshots found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

{{-- JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const fundSelect = document.getElementById('fund-select');
    const monthSelect = document.getElementById('month-select');
    const monthsBaseUrl = "{{ url('admin/fund-performance-snapshots/months') }}";

    fundSelect.addEventListener('change', function () {
        const fundId = this.value;
        monthSelect.innerHTML = '<option value="">-- Select Month --</option>';
        if (!fundId) return;

        fetch(monthsBaseUrl + '/' + fundId, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if (!Array.isArray(data)) return;

            data.forEach(row => {
                const opt = document.createElement('option');
                opt.value = row.month_end;
                opt.text = row.month_end;
                monthSelect.appendChild(opt);
            });

            if (data.length > 0) {
                monthSelect.selectedIndex = 1;
            }
        })
        .catch(console.error);
    });
});
</script>

@endsection
