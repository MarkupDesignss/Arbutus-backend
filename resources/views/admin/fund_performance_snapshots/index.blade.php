@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3 listing_name">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Fund Performance Snapshots</h3>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="mb-3">Generate Performance Snapshot</h5>
                    <form id="snapshot-form" method="POST" action="{{ route('admin.fund.performance.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Fund</label>
                            <select id="fund-select" name="fund_id" class="form-select">
                                <option value="">-- Select Fund --</option>
                                @foreach($funds as $fund)
                                <option value="{{ $fund->id }}" data-fundatakey="{{ $fund->fundatakey }}">
                                    {{ $fund->fund_name }} - {{ $fund->fundatakey }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">As Of Month</label>
                            <select id="month-select" name="as_of_month" class="form-select">
                                <option value="">-- Select Month --</option>
                            </select>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary">Calculate</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-8">
                    <h5 class="mb-3">Snapshots</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="text-uppercase">
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
                                    <td>{{ $s->is_published ? 'Published' : 'Draft' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No snapshots found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fundSelect = document.getElementById('fund-select');
    const monthSelect = document.getElementById('month-select');
    const monthsBaseUrl = "{{ url('admin/fund-performance-snapshots/months') }}";

    fundSelect.addEventListener('change', function() {
        const fundId = this.value;
        monthSelect.innerHTML = '<option value="">-- Select Month --</option>';
        if (!fundId) return;

        fetch(monthsBaseUrl + '/' + fundId, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
            .then(r => r.json())
            .then(data => {
                if (!Array.isArray(data) || data.length === 0) return;
                data.forEach((row) => {
                    const opt = document.createElement('option');
                    opt.value = row.month_end;
                    opt.text = row.month_end + ' - ' + (row.monthly_return ?? '');
                    opt.dataset.monthlyReturn = row.monthly_return;
                    opt.dataset.distributionYield = row.distribution_yield;
                    monthSelect.appendChild(opt);
                });

                // auto-select the first (most recent) month
                monthSelect.selectedIndex = 1;
            })
            .catch(err => console.error(err));
    });
});
</script>

@endsection