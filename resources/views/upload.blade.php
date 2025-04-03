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

                        <h2 class="card-title">Analytics Center</h2>
                    </header>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form class="form-horizontal form-bordered" method="post" action="{{ route('upload.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group row pb-4">
                                <label class="col-lg-3 control-label text-lg-end pt-2">File Upload</label>
                                <div class="col-lg-6">
                                    <input name="files[]" type="file" class="dropify" data-height="200" data-max-file-size="2M" data-allowed-file-extensions="jpg jpeg png gif pdf doc docx" multiple />
                                </div>
                            </div>
                            <div class="form-group row pb-4">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                            <div class="form-group row pb-4">
                                <div class="col-lg-3"></div>
                                <div class="col-lg-6">
                                    <p class="text-warning">The process will be analysed in the background and the result will be accessible on upload table</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    <!-- end: page -->
</section>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize Dropify
        $('.dropify').dropify({
            messages: {
                'default': 'Drag and drop a multiple files here or click',
                'replace': 'Drag and drop or click to replace',
                'remove': 'Remove',
                'error': 'Ooops, something wrong happened.'
            },
            error: {
                'fileSize': 'The file size is too big (2MB max).',
                'minWidth': 'The image width is too small.',
                'maxWidth': 'The image width is too big.',
                'minHeight': 'The image height is too small.',
                'maxHeight': 'The image height is too big.',
                'imageFormat': 'The file format is not allowed. Allowed formats: jpg, jpeg, png, gif, pdf, doc, docx'
            }
        });

        // Add custom CSS for the placeholder text
        $('<style>')
            .prop('type', 'text/css')
            .html(`
                .dropify-wrapper .dropify-message span.file-icon {
                    font-size: 14px;
                }
                .dropify-wrapper .dropify-message p {
                    font-size: 14px;
                    margin-top: 5px;
                }
            `)
            .appendTo('head');
    });
</script>
@endpush
@endsection