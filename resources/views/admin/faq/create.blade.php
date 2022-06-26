@extends('admin.layouts.app')

@section('title')Admin || FAQ @endsection
@section('head')
@endsection
@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Faq</h4>
                    <div class="card-header-action">
                        <a href="{{ route('admin.faq.list') }}" class="btn btn-primary">List Faqs</a>
                    </div>
                </div>
                <form action="{{ route('admin.faq.submit') }}" method="POST">
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif

                        @csrf
                        <div class="form-group">
                            <label>Question</label>
                            <textarea class="form-control @error('question') is-invalid @enderror" id="question"
                                name="question" required>{{ old('question') }}</textarea>
                            @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Answer</label>
                            <textarea class="form-control @error('answer') is-invalid @enderror" id="answer"
                                name="answer" required>{{ old('answer') }} </textarea>
                            @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
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
@endsection