@extends('admin.layouts.app')

@section('title')Admin || FAQ @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endsection
@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Blog</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.blog.list') }}" class="btn btn-primary">List Blogs</a>
                    </div>
                </div>
                <form action="{{ route('admin.blog.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" id="title" value="{{ $blog->title }}"
                                class="form-control @error('title') is-invalid @enderror" required>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Content</label>
                            <textarea name="content" id="content"
                                class="summernote form-control @error('content') is-invalid @enderror"
                                required>{{ $blog->title }}"</textarea>
                            @error('content')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <?php $image = (!empty($blog->image)) ? asset("uploads/blog") . '/' . $blog->image : "";?>
                            <input type="hidden" name="showimage" id="showimage" value="{{ $blog->image }}" />
                            <label>Thumbnail</label>
                            <div id="image-preview" class="image-preview" style="background-image: url('{{ $image }}');
                                background-size: cover;
                                background-position: center center;">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload"
                                    accept="image/png, image/gif, image/jpeg" />
                            </div>
                            @error('image')
                            <div class="d-block invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                    <div class="card-footer">
                        <button type="submit" value="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" value="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

@endsection

@section('script')
<script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
<script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/js/page/create-post.js') }}"></script>

@endsection