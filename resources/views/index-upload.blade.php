@extends('layouts.layout')

@section('content')
<section role="main" class="content-body card-margin">
    <header class="page-header">
        <h2>File Upload</h2>

        <div class="right-wrapper text-end">
            <ol class="breadcrumbs">
                <li>
                    <a href="index.html">
                        <i class="bx bx-home-alt"></i>
                    </a>
                </li>

                <li><span>Uploads</span></li>

            </ol>

            <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fas fa-chevron-left"></i></a>
        </div>
    </header>

    <!-- start: page -->
        <div class="row">
            <div class="col">
                <section class="card">
                    <header class="card-header">
                        <div class="card-actions">
                            <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                            <a href="#" class="card-action card-action-dismiss" data-card-dismiss></a>
                        </div>

                        <h2 class="card-title">Upload History</h2>
                    </header>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="mb-3">
                            <a href="{{ route('upload.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus"></i> Create Upload
                            </a>
                        </div>

                        <table class="table table-bordered table-striped mb-0" id="datatable-default">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Upload Date</th>
                                    <th>Files</th>
                                    <th>Status</th>
                                    <th>Analysed At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($uploads as $upload)
                                    <tr>
                                        <td>{{ $upload->id }}</td>
                                        <td>{{ $upload->created_at->format('Y-m-d H:i:s') }}</td>
                                        <td>{{ $upload->uploadedImages->count() }} files</td>
                                        <td>
                                            @if($upload->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @elseif($upload->status === 'processing')
                                                <span class="badge bg-warning">Processing</span>
                                            @else
                                                <span class="badge bg-danger">Failed</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $upload->analysed_at ? $upload->analysed_at->format('Y-m-d H:i:s') : 'Not yet analysed' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('upload.show', $upload->id) }}" class="btn btn-sm btn-info">
                                                <i class="bx bx-show"></i> View
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No uploads found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="mt-3">
                            {{ $uploads->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    <!-- end: page -->
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#datatable-default').DataTable({
            "order": [[ 0, "desc" ]],
            "pageLength": 10,
            "language": {
                "paginate": {
                    "previous": '<i class="fas fa-angle-left"></i>',
                    "next": '<i class="fas fa-angle-right"></i>'
                }
            }
        });
    });
</script>
@endpush
@endsection