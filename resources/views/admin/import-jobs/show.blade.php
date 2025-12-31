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
                            @if($job->status == 'processing') <span class="badge bg-warning text-dark">Processing</span> @endif
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
                                <pre>{{ json_encode(json_decode($job->summary), JSON_PRETTY_PRINT) }}</pre>
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
