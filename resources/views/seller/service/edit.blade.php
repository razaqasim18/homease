@extends('seller.layouts.app')

@section('title')Seller || Service @endsection
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}"> -->
<link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}">

<link rel="stylesheet" href="{{ asset('assets/bundles/dropzonejs/dropzone.css') }}">
<style>
.dropzoneDragArea {
    background-color: #fbfdff;
    border: 1px dashed #c0ccda;
    border-radius: 6px;
    padding: 60px;
    text-align: center;
    margin-bottom: 15px;
    cursor: pointer;
}

.dropzone {
    box-shadow: 0px 2px 20px 0px #f2f2f2;
    border-radius: 10px;
}

.dz-preview.dz-image-preview {
    margin: 0px 10px 10px 0px;
}

.dropzone-previews {
    display: flex;
    width: 100%;
    overflow: scroll;
}


.dz-success-mark {
    display: none;
}

.dz-error-mark {
    display: none;
}
</style>
@endsection
@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add Service</h4>
                    <div class="card-header-action">
                        <a href="{{ route('seller.service.list') }}" class="btn btn-primary">List Service</a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    <form action="{{ route('seller.service.update',$service->id) }}" name="demoform" id="demoform"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label>Question</label>
                                <select id="category" name="category" class="form-control" required>
                                    <option value="">Select an option</option>
                                    @foreach($category as $row)
                                    <option value="{{ $row->id }}" @php $result=($row->id == $service->category_id) ?
                                        "selected" : "";
                                        @endphp
                                        {{$result}}
                                        >
                                        {{ $row->category }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <input id="title" name="title"
                                    class="form-control form-control @error('title') is-invalid @enderror"
                                    value="{{  $service->title }}" required />
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <input type="hidden" class="serviceid" name="serviceid" id="serviceid"
                                    value="{{ $service->id}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Price</label>
                                <input type="number" id="price" name="price"
                                    class="form-control form-control @error('price') is-invalid @enderror"
                                    value="{{  $service->price }}" />
                                @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description" required>{{  $service->description }}</textarea>
                                @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <div class="form-group">
                                    <?php $image = (!empty($service->image)) ? asset("uploads/service") . '/' . $service->image : "";?>
                                    <input type="hidden" name="showimage" id="showimage"
                                        value="{{ $service->image }}" />
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
                        </div>
                        <div class="form-group">
                            <div id="dropzoneDragArea" class="dz-default dz-message dropzoneDragArea">
                                <span>Upload file</span>
                            </div>
                            <div class="dropzone-previews">
                                @foreach($serviceimage as $row)
                                <div class="dz-preview dz-image-preview">
                                    <div class="dz-image">
                                        <img data-dz-thumbnail="" alt="{{$row->image}}"
                                            src="{{ asset('uploads/service').'/'.$row->image}}" height="120px;"
                                            width="120px;">
                                    </div>
                                    <div class="dz-filename">
                                        <span data-dz-name="">{{$row->image}}</span>
                                    </div>
                                    <a class="dz-remove" href="javascript:void(0)" id="deletImagebutton"
                                        data-id="{{$row->id}}" data-dz-remove="">Remove
                                        file</a>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <input type="submit" id="form_submit_button" value="submit" class="btn btn-primary">
                        <button type="reset" value="reset" class="btn btn-secondary">Reset</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('script')
<script src="{{ asset('assets/bundles/upload-preview/assets/js/jquery.uploadPreview.min.js') }}"></script>
<script src="{{ asset('assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/js/page/create-post.js') }}"></script>


<script src="{{ asset('assets/bundles/dropzonejs/min/dropzone.min.js') }}"></script>
<!-- Page Specific JS File -->
<script>
Dropzone.autoDiscover = false;
// Dropzone.options.demoform = false;
let token = $('meta[name="csrf-token"]').attr('content');
$(function() {
    var myDropzone = new Dropzone("div#dropzoneDragArea", {
        paramName: "file",
        url: "{{ url('/seller/service/storeUpdateImage') }}",
        previewsContainer: 'div.dropzone-previews',
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 10,
        maxFiles: 5,
        params: {
            _token: token
        },
        // The setting up of the dropzone
        init: function() {
            var myDropzone = this;
            //form submission code goes here
            $("form[name='demoform']").submit(function(event) {
                //Make sure that the form isn't actully being sent.
                event.preventDefault();
                URL = $("#demoform").attr('action');
                // formData = $('#demoform').serialize();
                var form = $('#demoform')[0];
                var data = new FormData(form)
                $.ajax({
                    type: 'POST',
                    url: URL,
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(result) {
                        var result = jQuery.parseJSON(result);
                        var typeOfResponse = result['type'];
                        var res = result['msg'];
                        if (typeOfResponse == 0) {
                            swal('Error', res, 'error');
                        } else if (typeOfResponse == 1) {
                            // fetch the useid
                            var res = result['serviceid'];
                            $("#serviceid").val(
                                res); // inseting userid into hidden input field
                            //process the queue
                            if (myDropzone.getAcceptedFiles().length) {
                                //allow to upload file
                                myDropzone.processQueue();
                            } else {
                                swal({
                                    title: 'Success',
                                    text: "Data is saved successfully",
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

                        } else {
                            console.log("error");
                        }
                    }
                });
            });
            //Gets triggered when we submit the image.
            this.on('sending', function(file, xhr, formData) {
                //fetch the user id from hidden input field and send that userid with our image
                let serviceid = document.getElementById('serviceid').value;
                formData.append('serviceid', serviceid);
            });

            this.on("success", function(file, response) {

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
                // //reset the form
                // $('#demoform')[0].reset();
                // //reset dropzone
                // $('.dropzone-previews').empty();

            });
            this.on("queuecomplete", function() {

            });

            // Listen to the sendingmultiple event. In this case, it's the sendingmultiple event instead
            // of the sending event because uploadMultiple is set to true.
            this.on("sendingmultiple", function() {
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
            });

            this.on("successmultiple", function(files, response) {
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
            });

            this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
            });
        }
    });
});

$(document).ready(function() {

    $("a#deletImagebutton").click(function() {

        var id = $(this).data("id");
        swal({
                title: 'Are you sure?',
                text: 'Once deleted, you will not be able to recover this action!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var url = '{{ url("/seller/service/image/delete") }}' + '/' + id;
                    $.ajax({
                        // url: "{{ route('admin.faq.delete', $row->id) }}",
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
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
                }
            });
    });
});
</script>

@endsection