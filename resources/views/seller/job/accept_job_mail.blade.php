@extends('layouts.mail')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ $title }}</div>
                <div class="card-body">
                    <h1>{{ $msg }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection