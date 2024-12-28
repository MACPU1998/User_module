@extends('layouts.project-master')

@section('title', 'Otomatic - smart cloud platform')

@section('headerStyle')
        <!-- DataTables -->
        <link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
 <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">

                             @component('common-components.breadcrumb')
                                 @slot('title') Gateways @endslot
                                 @slot('item1') Home @endslot
                                 @slot('item2') Smart @endslot
                                 @endcomponent

                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <div class="card report-card">
                                <div class="card-body">
                                    <div class="float-right">
                                        <i class="fas fa-align-justify  bg-soft-warning main-widgets-icon"></i>
                                    </div>
                                    <h4 class="title-text mt-0">Gateways</h4>
                                    <h3 class="my-3">{{count($gates)}} <small>Total</small></h3>
                                    <p class="mb-0 text-muted text-truncate"> Last register <span class="text-success">...</span></p>
                                </div>
                            </div><!--end card-->
                        </div> <!--end col-->
                        <div class="col-md-4">
                            <div class="card report-card">
                                <div class="card-body">
                                    <div class="float-right">
                                        <i class=" fab fa-mixcloud bg-soft-success main-widgets-icon"></i>
                                    </div>
                                    <h4 class="title-text mt-0">Online</h4>
                                    <h3 class="my-3">0 <small>Total</small></h3>
                                    <p class="mb-0 text-muted text-truncate">Last Online <span class="text-success">...</span></p>
                                </div>
                            </div><!--end card-->
                        </div> <!--end col-->
                    </div><!--end row-->

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <button type="button" class="btn btn-gradient-primary px-4 mt-0 mb-3"data-toggle="modal" data-target="#newg_modal" data-animation="bounce"><i class="mdi mdi-plus-circle-outline mr-2"></i>New Gateway</button>
                                    <div class="table-responsive">
                                        <table id="datatable" class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>Model</th>
                                                <th>Serial Number</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Note</th>
                                                <th class="text-right">Action</th>
                                            </tr><!--end tr-->
                                            </thead>

                                            <tbody>
                                            @if($gates!=null)
                                            @foreach($gates as $g)
                                            <tr>
                                                <td>XGIP.11</td>
                                                <td>{{$g->serialNumber}}</td>
                                                <td>{{$g->remark}}</td>
                                                <td>
                                                    @if($g->technicianUserId!=null)
                                                        <span class="badge badge-soft-success">Registered</span>
                                                    @else
                                                        <span class="badge badge-soft-warning">Not register</span>
                                                    @endif
                                                        @if($g->ban['banned'])
                                                            <span class="badge badge-soft-danger">Banned</span>
                                                        @endif

                                                </td>
                                                <td>{{$g->note}}</td>
                                                <td class="text-right">
                                                    <button data-button="{{$g->id}}" id="edit-item" class="mr-2 btn btn-circle"><i class="fas fa-edit text-info font-16"></i></button>
                                                    <button data-button="{{$g->id}}" id="remove-item" class="btn btn-circle"><i class="fas fa-trash-alt text-danger font-16"></i></button>
                                                </td>
                                            </tr><!--end tr-->
                                            @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div> <!--end col-->
                    </div><!--end row-->

     <div class="modal fade" id="newg_modal" tabindex="-1" role="dialog" aria-labelledby="newType" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title mt-0" id="exampleModalLabel">Add new device type</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form>

                         <div class="form-group">
                             <label for="exampleInputEmail1">Serial</label>
                             <input type="text" class="form-control" id="serial" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">SW</label>
                             <input type="text" class="form-control" id="SW" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">Remark</label>
                             <input type="text" class="form-control" id="remark" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">Note</label>
                             <input type="text" class="form-control" id="note" aria-describedby="" placeholder="">
                         </div>

                     </form>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button id="addg-btn" type="button" class="btn btn-primary">Confirm</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     <div class="modal fade" id="editg_modal" tabindex="-1" role="dialog" aria-labelledby="newType" aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title mt-0" id="exampleModalLabel">Add new device type</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <form>

                         <div class="form-group">
                             <label for="exampleInputEmail1">Serial</label>
                             <input type="text" class="form-control" id="serial" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">SW</label>
                             <input type="text" class="form-control" id="SW" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">Remark</label>
                             <input type="text" class="form-control" id="remark" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group form-check">
                             <input type="checkbox" class="form-check-input" id="banned">
                             <label class="form-check-label" for="ban">Ban</label>
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">Ban reason</label>
                             <input type="text" class="form-control" id="banReason" aria-describedby="" placeholder="">
                         </div>
                         <div class="form-group">
                             <label for="exampleInputEmail1">Note</label>
                             <input type="text" class="form-control" id="note" aria-describedby="" placeholder="">
                         </div>

                     </form>
                     <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                         <button id="editg-btn" type="button" class="btn btn-primary">Confirm</button>
                     </div>
                 </div>
             </div>
         </div>
     </div>
@stop

@section('footerScript')
        <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
         <script src="{{ URL::asset('plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
         <script>
             const delay = millis => new Promise((resolve, reject) => {
                 setTimeout(_ => resolve(), millis)
             });

             //$('table').DataTable();

             $(document).ready(function() {
                 var gid = 0;
                 $("#newg_modal").on("click","#addg-btn", function(event) {
                     event.preventDefault();
                     var SW = $("#newg_modal #SW").val();
                     var serial = $("#newg_modal #serial").val();
                     var remark = $("#newg_modal #remark").val();
                     var note = $("#newg_modal #note").val();

                     $.ajax({
                         type: "POST",
                         url: "/gateway/add",
                         data: {
                             _token: "{{csrf_token()}}",
                             SW: SW,
                             serial: serial,
                             remark: remark,
                             note:  note,
                         },
                         success: function(data){
                             if(data.success==false){
                                 Swal.fire(
                                     'Warning!',
                                     data.msg,
                                     'warning'
                                 )
                             } else if(data.success==true){
                                 //Success Message
                                 $('#newg_modal').modal('hide');
                                 Swal.fire(
                                     'Successful!',
                                     'New type added!',
                                     'success'
                                 )
                                 delayRedirect("/smart/gateways");
                             }
                         },error: function (reject) {

                         }
                     });
                     return false;
                 });
                 async function delayRedirect(url){
                     await delay(500);
                     window.location.replace(url);
                 }
                 $(".table tr").on("click",'#remove-item', function() {
                     gid = $(this).attr('data-button');
                     Swal.fire({
                         title: 'Are you sure?',
                         text: "You won't be able to revert this!",
                         icon: 'warning',
                         showCancelButton: true,
                         confirmButtonColor: '#3085d6',
                         cancelButtonColor: '#d33',
                         confirmButtonText: 'Yes, delete it!'
                     }).then((e) => {
                         if (e.value) {
                             $.ajax({
                                 type: "POST",
                                 url: "/gateway/remove",
                                 data: {
                                     _token: "{{csrf_token()}}",
                                     id: gid
                                 },
                                 success: function (data) {
                                     if(data.success){
                                         Swal.fire(
                                             'Successful!',
                                             'removed!',
                                             'success'
                                         )
                                         delayRedirect("/smart/gateways");
                                     } else {
                                         Swal.fire(
                                             'warning!',
                                             data.msg,
                                             'warning'
                                         )
                                     }

                                 }
                             });
                         }else if(e.dismiss="cancel"){

                         }else{
                             Swal.fire(
                                 'warning!',
                                 "error occured!",
                                 'warning'
                             )
                         }
                     });
                 });
                 $(".table").on("click",'#edit-item', function() {
                     gid = $(this).attr('data-button');
                     $.ajax({
                         type: "POST",
                         url: "/gateway/get",
                         data: {
                             _token: "{{csrf_token()}}",
                             id: gid
                         },
                         success: function (data) {
                             if(data.success){
                                 $("#editg_modal #serial").val(data.gate.serialNumber);
                                 $("#editg_modal #remark").val(data.gate.remark);
                                 $("#editg_modal #SW").val(data.gate.SW);
                                 $("#editg_modal #banReason").val(data.gate.banReason);
                                 $("#editg_modal #note").val(data.gate.note);
                                 if(data.gate.banned){
                                     $("#editg_modal #banned").prop('checked', true);
                                 }else{
                                     $("#editg_modal #banned").prop('checked', false);
                                 }
                                 $("#editg_modal").modal('show');
                             } else {

                             }

                         }
                     });
                 });
                 $("#editg_modal").on("click","#editg-btn", function(event) {
                     event.preventDefault();
                     var serial = $("#editg_modal #serial").val();
                     var SW = $("#editg_modal #SW").val();
                     var remark = $("#editg_modal #remark").val();
                     var note = $("#editg_modal #note").val();
                     var banReason = $("#editg_modal #banReason").val();

                     var b = false;
                     if ($("#editg_modal #banned").is(":checked"))
                     {
                         b = true;
                     }else{
                         b = false;
                     }
                     $.ajax({
                         type: "POST",
                         url: "/gateway/edit",
                         data: {
                             _token: "{{csrf_token()}}",
                             id: gid,
                             serialNumber: serial,
                             SW: SW,
                             note: note,
                             remark:remark,
                             banned: b,
                             banReason: banReason
                         },
                         success: function(data){
                             if(data.success==false){
                                 Swal.fire(
                                     'Warning!',
                                     data.msg,
                                     'warning'
                                 )
                             } else if(data.success==true){
                                 //Success Message
                                 $('#newtype_modal').modal('hide');
                                 Swal.fire(
                                     'Successful!',
                                     'The gateway updated!',
                                     'success'
                                 )
                                 delayRedirect("/smart/gateways");
                             }
                         }
                     });
                     return false;
                 });
             });
         </script>
@stop
