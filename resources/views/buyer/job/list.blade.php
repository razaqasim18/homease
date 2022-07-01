@extends('buyer.layouts.app')

@section('title')Buyer || Job @endsection
@section('head')
<link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
<link rel="stylesheet"
    href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Job List</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover" id="save-stage" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Sr#</th>
                                    <th>Service</th>
                                    <th>Seller name</th>
                                    <th>Status</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1;?>
                                @foreach($jobs as $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $row->servicetitle }}
                                    </td>
                                    <td>
                                        {{ $row->sellername }}
                                    </td>
                                    <td>
                                        @if($row->jobstatus == 0)
                                        <div class="badge badge-primary">Requested</div>
                                        @elseif($row->jobstatus == 1)
                                        <div class="badge badge-info">Accpted</div>
                                        @elseif($row->jobstatus == 2)
                                        <div class="badge badge-info">In-progress</div>
                                        @elseif($row->jobstatus == 3)
                                        <div class="badge badge-secondary">Waiting For Approval</div>
                                        @elseif($row->jobstatus == 4)
                                        <div class="badge badge-success">Verified</div>
                                        @elseif($row->jobstatus == 5)
                                        <div class="badge badge-success">Completed</div>
                                        @else
                                        <div class="badge badge-danger">Rejected</div>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $row->price }}
                                    </td>
                                    <td>
                                        {{ date("d-m-Y",strtotime($row->date)) }}
                                    </td>
                                    <td style="display: -webkit-inline-box">
                                        @if($row->jobstatus == 0 || $row->jobstatus == -1)
                                        <button data-id="{{ $row->jobid}}" type="button" id="deletButton"
                                            class="btn btn-sm btn-danger m-1">
                                            <i data-feather="trash-2"></i>
                                        </button>
                                        @endif
                                        @if($row->jobstatus == 3)
                                        <button data-id="{{ $row->jobid}}" type="button" id="approveButton"
                                            class="btn btn-sm btn-success m-1">
                                            <i data-feather="git-commit"></i>
                                        </button>
                                        @endif
                                        @if($row->jobstatus == 4)
                                        <a href="{{ route('buyer.job.review',base64_encode($row->jobid)) }}"
                                            class="btn btn-sm btn-primary m-1"><i data-feather="star"></i></a>
                                        @endif
                                        @if($row->jobstatus == 5)
                                        <a href="{{ route('buyer.job.review.view',base64_encode($row->jobid)) }}"
                                            class="btn btn-sm btn-primary m-1"><i data-feather="eye"></i></a>
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
$(document).ready(function() {
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
                    var url = '{{ url("/buyer/job/delete") }}' + '/' + id;
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            "id": id,
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

    $("#save-stage").on("click", "button#approveButton", function() {
        var id = $(this).data("id");
        swal({
                title: 'Are you sure?',
                text: 'You Want To Approve The Job!',
                icon: 'warning',
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    var token = $("meta[name='csrf-token']").attr("content");
                    var url = '{{ url("/buyer/job/approve") }}' + '/' + id;
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            "id": id,
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
});
</script>
@endsection