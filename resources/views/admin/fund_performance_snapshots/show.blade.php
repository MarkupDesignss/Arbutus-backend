@extends('admin.layouts.admin')
@section('content')
<div class="container">
    <h1>Snapshot Details - {{ $snapshot->fund->fundatakey ?? 'Fund' }} ({{ $snapshot->as_of_month }})</h1>

    <div class="card mb-3">
        <div class="card-body">
            <p><strong>One Month:</strong> {{ number_format($snapshot->one_month * 100, 2) }}%</p>
            <p><strong>YTD:</strong> {{ is_null($snapshot->ytd) ? '-' : number_format($snapshot->ytd * 100, 2) . '%' }}</p>
            <p><strong>One Year:</strong> {{ is_null($snapshot->one_year) ? '-' : number_format($snapshot->one_year * 100, 2) . '%' }}</p>
            <p><strong>Three Year (annualised):</strong> {{ is_null($snapshot->three_year) ? '-' : number_format($snapshot->three_year * 100, 2) . '%' }}</p>
            <p><strong>Since Inception (annualised):</strong> {{ is_null($snapshot->since_inception) ? '-' : number_format($snapshot->since_inception * 100, 2) . '%' }}</p>
            <p><strong>Three Year Std Dev (annualised):</strong> {{ is_null($snapshot->three_year_std_dev) ? '-' : number_format($snapshot->three_year_std_dev * 100, 2) . '%' }}</p>
            <p><strong>Distribution Yield:</strong> {{ is_null($snapshot->distribution_yield) ? '-' : number_format($snapshot->distribution_yield, 2) . '%' }}</p>
            <p><strong>Published:</strong> {{ $snapshot->is_published ? 'Yes' : 'No' }}</p>
        </div>
    </div>

    <h3>Monthly Returns (most recent first)</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Month End</th>
                <th>Monthly Return</th>
                <th>Distribution Yield</th>
            </tr>
        </thead>
        <tbody>
            @foreach($monthlyReturns as $row)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($row->month_end)->format('Y-m-d') }}</td>
                    <td>{{ is_null($row->monthly_return) ? '-' : number_format($row->monthly_return * 100, 2) . '%' }}</td>
                    <td>{{ is_null($snapshot->distribution_yield) ? '-' : number_format($snapshot->distribution_yield, 2) . '%' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.fund.performance.list') }}" class="btn btn-secondary">Back to list</a>
</div>
@endsection
