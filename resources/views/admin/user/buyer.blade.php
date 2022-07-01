@extends('admin.layouts.app')

@section('title')Admin || Buyer @endsection
@section('head')
<meta name='csrf-token' content="{{ csrf_token() }}" <link rel="stylesheet"
    href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
@endsection
@section('content')

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Buyer List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Verified</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                @foreach($users as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $row->name }}
                                    </td>
                                    <td>
                                        {{ $row->email }}
                                    </td>
                                    <td>
                                        {{ $row->phone }}
                                    </td>
                                    <td>
                                        @if($row->isverified)
                                        <div class="badge badge-success">Verified</div>
                                        @else
                                        <div class="badge badge-danger">Not-verified</div>
                                        @endif
                                    </td>
                                    <td style="display: -webkit-inline-box">
                                        @if($row->isblocked)
                                        <button data-id="{{ $row->id}}" data-status="0" type="button" id="unblockButton"
                                            class="btn btn-sm btn-primary m-1">
                                            <span>Un-block</span>
                                        </button>
                                        @else
                                        <button data-id="{{ $row->id}}" data-status="1" type="button" id="unblockButton"
                                            class="btn btn-sm btn-danger m-1">
                                            <span>Block</span>
                                        </button>
                                        @endif
                                        @if($row->isdeleted)
                                        <button data-id="{{ $row->id}}" data-status="0" type="button" id="deletButton"
                                            class="btn btn-sm btn-primary m-1">
                                            <span>Restore</span>
                                        </button>

                                        @else
                                        <button data-id="{{ $row->id}}" data-status="1" type="button" id="deletButton"
                                            class="btn btn-sm btn-danger m-1">
                                            <span>Delete</span>
                                        </button>
                                        @endif
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

@endsection

@section('script')
<script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}">
</script>
<script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Page Specific JS File -->
<script src="{{ asset('assets/js/page/datatables.js') }}"></script>
<script>
$("#save-stage").on("click", "button#unblockButton", function() {
    var id = $(this).data("id");
    var status = $(this).data("status");
    swal({
            title: 'Are you sure?',
            text: 'You want to perform this action!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var token = $("meta[name='csrf-token']").attr("content");
                var url = '{{ url("/admin/users/buyer/block") }}' + '/' + id;
                $.ajax({
                    // url: "{{ route('admin.faq.delete', $row->id) }}",
                    url: url,
                    type: 'POST',
                    data: {
                        "id": id,
                        "status": status,
                        "_token": token,
                    },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    complete: function() {
                        $(".loader").hide();
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
$("#save-stage").on("click", "button#deletButton", function() {
    var id = $(this).data("id");
    var status = $(this).data("status");
    swal({
            title: 'Are you sure?',
            text: 'You want to perform this action!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                var token = $("meta[name='csrf-token']").attr("content");
                var url = '{{ url("/admin/users/buyer/deleted") }}' + '/' + id;
                $.ajax({
                    // url: "{{ route('admin.faq.delete', $row->id) }}",
                    url: url,
                    type: 'POST',
                    data: {
                        "id": id,
                        "status": status,
                        "_token": token,
                    },
                    beforeSend: function() {
                        $(".loader").show();
                    },
                    complete: function() {
                        $(".loader").hide();
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
</script>
@endsection