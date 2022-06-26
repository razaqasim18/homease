@extends('admin.layouts.app')

@section('title')Admin || Profile @endsection
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
<link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">
@endsection
@section('content')

<section class="section">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card author-box">
                <div class="card-body">
                    <div class="author-box-center">
                        <?php $profile = (!empty(Auth::user()->image)) ? asset("uploads/profile") . '/' . Auth::user()->image : asset('assets/img/users/user-1.png');?>
                        <img alt="image" src="{{ $profile }}" class="rounded-circle author-box-picture">
                        <div class="clearfix"></div>
                        <div class="author-box-name">
                            <a href="#">{{ Auth::user()->name }}</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-12 col-md-12 col-lg-8">
            <div class="card">
                <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                                aria-selected="true">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                                aria-selected="false">Setting</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="profile-tab3" data-toggle="tab" href="#password" role="tab"
                                aria-selected="false">Password</a>
                        </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                            <div class="row">
                                <div class="col-md-3 col-6 b-r">
                                    <strong>Name</strong>
                                    <br>
                                    <p class="text-muted">{{ Auth::user()->name }}</p>
                                </div>
                                <div class="col-md-3 col-6 b-r">
                                    <strong>UserName</strong>
                                    <br>
                                    <p class="text-muted">{{ Auth::user()->username }}</p>
                                </div>
                                <div class="col-md-3 col-6 b-r">
                                    <strong>Mobile</strong>
                                    <br>
                                    <p class="text-muted">{{ Auth::user()->phone }}</p>
                                </div>
                                <div class="col-md-3 col-6 b-r">
                                    <strong>Email</strong>
                                    <br>
                                    <p class="text-muted">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                            <form id="profileUpdate" method="POST" enctype="multipart/form-data">
                                <div class="card-header">
                                    <h4>Edit Profile</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Name</label>
                                            <input type="text" id="name" name="name" class="form-control"
                                                value="{{ Auth::user()->name }}" required>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>User Name</label>
                                            <input type="text" id="username" name="username" class="form-control"
                                                value="{{ Auth::user()->username }}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6 col-12">
                                            <label>Email</label>
                                            <input type="email" id="email" name="email" class="form-control"
                                                value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                        <div class="form-group col-md-6 col-12">
                                            <label>Phone</label>
                                            <input type="tel" id="phone" name="phone" class="form-control"
                                                value="{{ Auth::user()->phone }}" required>
                                        </div>
                                        <div class="form-groupcol-md-6 col-12">
                                            <?php $image = (!empty(Auth::user()->image)) ? asset("uploads/profile") . '/' . Auth::user()->image : "";?>
                                            <input type="hidden" name="showimage" id="showimage"
                                                value="{{ Auth::user()->image }}" />
                                            <div id="image-preview" class="image-preview"
                                                style="background-image: url('{{ $image }}'); background-size: cover; background-position: center center;">
                                                <label for="image-upload" id="image-label">Choose File</label>
                                                <input type="file" name="image" id="image-upload"
                                                    accept="image/png, image/gif, image/jpeg" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="profileButton" type="button" class="btn btn-primary">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab2">
                            <form id="passwordUpdate" method="POST">
                                <div class="card-header">
                                    <h4>Change Password</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label>Old Password</label>
                                            <input type="password" id="oldpassword" name="oldpassword"
                                                class="form-control" value="" required>
                                        </div>
                                        <div class="form-group col-md-12 col-12">
                                            <label>New Password</label>
                                            <input type="password" id="newpassword" name="newpassword"
                                                class="form-control" value="" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-12 col-12">
                                            <label>New Password</label>
                                            <input type="password" id="confpassword" name="confpassword"
                                                class="form-control" value="" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button id="passwordButton" type="button" class="btn btn-primary">Save
                                        Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
<script>
$("button#profileButton").click(function() {
    var $myForm = $('form#profileUpdate')
    if (!$myForm[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        // $myForm.find(':submit').click();
        $myForm[0].reportValidity();
        return false;
    }
    var url = '{{ url("admin/profile/update") }}';
    var token = $("meta[name='csrf-token']").attr("content");
    var name = $("input#name").val();
    var username = $("input#username").val();
    var phone = $('input#phone').val();
    var profile = $('input#image-upload')[0].files;
    var showimage = $('input#showimage').val();
    var fd = new FormData();
    fd.append('name', name);
    fd.append('username', username);
    fd.append('phone', phone);
    fd.append('image', profile[0]);
    fd.append('showimage', showimage);
    fd.append('_token', token);
    $.ajax({
        url: url,
        type: "POST",
        data: fd,
        // dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            var result = jQuery.parseJSON(response);
            var typeOfResponse = result['type'];
            var res = result['msg'];
            if (typeOfResponse == 0) {
                swal('Error', res, 'error');
            } else if (typeOfResponse == 1) {
                swal({
                    title: 'Success',
                    text: res,
                    icon: 'success',
                    type: 'success',
                    showCancelButton: false, // There won't be any cancel button
                    showConfirmButton: true // There won't be any confirm button
                }).then((oK) => {
                    if (oK) {
                        if (oK) {
                            location.reload();
                        }
                    }
                });
            }
        }
    });
});
$("button#passwordButton").click(function() {
    var $myForm = $('form#passwordUpdate')
    if (!$myForm[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        // $myForm.find(':submit').click();
        $myForm[0].reportValidity();
        return false;
    }
    var url = '{{ url("admin/profile/password/update") }}';
    var token = $("meta[name='csrf-token']").attr("content");
    var oldpassword = $("input#oldpassword").val();
    var newpassword = $("input#newpassword").val();
    var confpassword = $('input#confpassword').val();
    var fd = new FormData();
    fd.append('oldpassword', oldpassword);
    fd.append('newpassword', newpassword);
    fd.append('confpassword', confpassword);
    fd.append('_token', token);
    $.ajax({
        url: url,
        type: "POST",
        data: fd,
        // dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            var result = jQuery.parseJSON(response);
            var typeOfResponse = result['type'];
            var res = result['msg'];
            if (typeOfResponse == 0) {
                swal('Error', res, 'error');
            } else if (typeOfResponse == 1) {
                swal({
                    title: 'Success',
                    text: res,
                    icon: 'success',
                    type: 'success',
                    showCancelButton: false, // There won't be any cancel button
                    showConfirmButton: true // There won't be any confirm button
                }).then((oK) => {
                    if (oK) {
                        if (oK) {
                            location.reload();
                        }
                    }
                });
            }
        }
    });
});
</script>
@endsection