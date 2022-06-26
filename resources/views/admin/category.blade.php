@extends('admin.layouts.app')

@section('title')Admin || Category @endsection
@section('head')
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Category List</h4>
                    <div class="card-header-action">
                        <button type="button" class="btn btn-primary" data-toggle="modal"
                            data-target="#exampleModalCenter">Add Category</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                @foreach($categorys as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $row->category }}
                                    </td>
                                    <td style="display: -webkit-inline-box">
                                        <button id="editcategory" data-id="{{ $row->id }}"
                                            data-category="{{ $row->category }}" class="btn btn-sm btn-primary m-1"><i
                                                data-feather="edit-2"></i>
                                        </button>
                                        <!-- <form action="{{ route('admin.blog.delete', $row->id)}}" method="post">
                                            @csrf
                                            @method('DELETE') -->
                                        <button data-id="{{ $row->id}}" type="button" id="deletButton"
                                            class="btn btn-sm btn-danger m-1">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                        <!-- </form> -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- New Model -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" id="insertForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Add Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="category" id="category"
                            class="form-control @error('title') is-invalid @enderror" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" id="insertButton" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Model -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="POST" id="editForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @method('PUT')
                    <input type="hidden" name="editid" id="editid"
                        class="form-control @error('title') is-invalid @enderror" required>

                    <div class="form-group">
                        <label>Category</label>
                        <input type="text" name="editcategory" id="editcategory"
                            class="form-control @error('title') is-invalid @enderror" required>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" id="updateButton" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>

<script>
$("button#insertButton").click(function() {
    var $myForm = $('form#insertForm')
    if (!$myForm[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        // $myForm.find(':submit').click();
        $myForm[0].reportValidity();
        return false;
    }
    var token = $("meta[name='csrf-token']").attr("content");
    var category = $("input#category").val();
    var url = '{{ url("/admin/category/insert") }}';
    $.ajax({
        url: url,
        type: 'POST',
        data: {
            "category": category,
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
});

$("#save-stage").on("click", "button#editcategory", function() {
    $("input#editid").val($(this).data('id'));
    $("input#editcategory").val($(this).data('category'));
    $("div#editModal").modal('show');
});

$("body").on("click", "button#updateButton", function() {
    var $myForm = $('form#editForm')
    if (!$myForm[0].checkValidity()) {
        // If the form is invalid, submit it. The form won't actually submit;
        // this will just cause the browser to display the native HTML5 error messages.
        // $myForm.find(':submit').click()
        $myForm[0].reportValidity();
        return false;
    }
    var token = $("meta[name='csrf-token']").attr("content");
    var id = $("input#editid").val();
    var category = $("input#editcategory").val();
    var url = '{{ url("/admin/category/update") }}' + '/' + id;
    $.ajax({
        url: url,
        type: 'PUT',
        data: {
            "category": category,
            "_token": token,
        },
        success: function(response) {
            console.log(response);
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

$("#save-stage").on("click", "button#deletButton", function() {
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
                var url = '{{ url("admin/category/delete") }}' + '/' + id;
                $.ajax({
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
                        console.log(res);
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
</script>
@endsection