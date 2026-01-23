@extends('admin.layouts.admin')
@section('content')

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 style="font-size: 1.5rem; color: #0d6efd;" class="mb-0 fw-bold">Import Job Details</h3>
        <a href="{{ route('admin.import-jobs.list') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left me-1"></i>Back to List
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Admin Name</th>
                        <td>{{ $job->admin->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Original Filename</th>
                        <td>{{ $job->original_filename }}</td>
                    </tr>
                    <tr>
                        <th>Stored Filename</th>
                        <td>{{ $job->stored_filename }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($job->status == 'uploaded') <span class="badge bg-primary">Uploaded</span> @endif
                            @if($job->status == 'validating') <span class="badge bg-info">Validating</span> @endif
                            @if($job->status == 'failed') <span class="badge bg-danger">Failed</span> @endif
                            @if($job->status == 'validated') <span class="badge bg-success">Validated</span> @endif
                            @if($job->status == 'processing') <span class="badge bg-warning text-dark">Processing</span>
                            @endif
                            @if($job->status == 'completed') <span class="badge bg-success">Completed</span> @endif
                        </td>
                    </tr>
                    <tr>
                        <th>As of Month</th>
                        <td>{{ $job->as_of_month }}</td>
                    </tr>
                    <tr>
                        <th>Total Rows</th>
                        <td>{{ $job->total_rows }}</td>
                    </tr>
                    <tr>
                        <th>Valid Rows</th>
                        <td>{{ $job->valid_rows }}</td>
                    </tr>
                    <tr>
                        <th>Invalid Rows</th>
                        <td>{{ $job->invalid_rows }}</td>
                    </tr>
                    <tr>
                        <th>Summary</th>
                        <td>
                            @if($job->summary)
                            @php
                            $summary = json_decode($job->summary, true);
                            @endphp

                            {{-- Coverage --}}
                            @if(isset($summary['coverage_percentage']))
                            <p class="mb-2">
                                <strong>Coverage Percentage:</strong>
                                {{ $summary['coverage_percentage'] }}%
                            </p>
                            @endif

                            {{-- Missing Funds --}}
                            @if(!empty($summary['missing_funds']))
                            <p class="mb-1"><strong>Missing Funds:</strong></p>
                            <ul>
                                @foreach($summary['missing_funds'] as $fund)
                                <li>Fundata Key: {{ $fund }}</li>
                                @endforeach
                            </ul>
                            @endif

                            {{-- Invalid Rows Sample --}}
                            @if(!empty($summary['invalid_rows_sample']))
                            <p class="mb-2"><strong>Invalid Rows (Sample):</strong></p>
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Fundata Key</th>
                                        <th>Month End</th>
                                        <th>Monthly Return</th>
                                        <th>Distribution Yield (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summary['invalid_rows_sample'] as $row)
                                    <tr>
                                        <td>{{ $row['fundatakey'] ?? 'N/A' }}</td>
                                        <td>{{ $row['month_end'] ?? 'N/A' }}</td>
                                        <td>{{ $row['monthly_return'] ?? 'N/A' }}</td>
                                        <td>{{ $row['distribution_yield'] ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                            @else
                            N/A
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <th>Created At</th>
                        <td>{{ $job->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Updated At</th>
                        <td>{{ $job->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection