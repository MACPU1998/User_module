@extends('layouts.project-master')

@section('title', 'otomatic - device types')

@section('headerStyle')
    <!-- DataTables -->
    <link href="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    <link href="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/css/otomatic.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
       <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">

                             @component('common-components.breadcrumb')
                                 @slot('title') Types @endslot
                                 @slot('item1') Home @endslot
                                 @slot('item2') Devices @endslot
                                 @endcomponent

                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="mt-0 header-title">Device Types</h4>
                                    <div class="row">
                                        <div class="col-md-3"><p class="text-muted mb-3">All type of devices in the platform.</p></div>
                                        <div class="col-md-3"><button type="button" class="btn btn-gradient-primary" data-toggle="modal" data-target="#newtype_modal" >Add</button>
                                    </div>

                                    </div>

                                    <div class="table-responsive">
                                        <table class="table mb-0 table-centered">
                                            <thead>
                                            <tr>
                                                <th>Icon</th>
                                                <th>Name</th>
                                                <th>Group</th>
                                                <th>Params</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                        @if($types!=null)
                                            @foreach($types as $type)
                                                <tr>
                                                    <td><img src="{{ URL::asset('assets/images/widgets/project1.jpg')}}" alt="" class="rounded-circle thumb-sm mr-1">
                                                    </td>
                                                    <td>{{$type->name}}</td>
                                                    <td>{{$type->group}}</td>
                                                    <td>
                                                        <ul>
                                                            @foreach($type->params as $t)
                                                                <li>{{"name: ".$t["name"].", max: ".$t["max"]}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown d-inline-block float-right">
                                                            <a class="nav-link dropdown-toggle arrow-none" id="dLabel4" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                                                <i class="fas fa-ellipsis-v font-20 text-muted"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dLabel4">
                                                                <button id="edit-item" class="dropdown-item" data-button="{{$type->id}}" >Edit</button>
                                                                <button id="remove-item" class="dropdown-item" data-button="{{$type->id}}" >Remove</button>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                            </tbody>
                                        </table><!--end /table-->
                                    </div><!--end /tableresponsive-->
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div> <!-- end col -->
                    </div> <!-- end row -->


           <div class="modal fade" id="newtype_modal" tabindex="-1" role="dialog" aria-labelledby="newType" aria-hidden="true">
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
                                   <label for="exampleInputEmail1">Name</label>
                                   <input type="text" class="form-control" id="name" aria-describedby="" placeholder="">
                               </div>
                               <div class="form-group">
                                   <label for="exampleInputEmail1">Group</label>
                                   <input type="text" class="form-control" id="group" aria-describedby="" placeholder="">
                               </div>
                               <div class="form-group form-check">
                                   <input type="checkbox" class="form-check-input" id="ignore">
                                   <label class="form-check-label" for="ignore">Ignore GUI</label>
                               </div>
                               <div id="attr-action" class="form-group">
                                           <br/>
                                           <input type="text" id="attributes" name="attributes" hidden/>
                                           <a id="attr-add" style="" class="btn btn-warning">submit</a>
                                           <input id="attr-name" class="form-control"  style="" placeholder="name"/>
                                           <input id="attr-value" class="form-control"  style="" placeholder="value"/>
                                           <div id="list-attrs" class="form-group" style="border:1px solid grey;border-radius: 5px;">
                                               <ul>

                                               </ul>
                                           </div>
                               </div>
                                </form>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               <button id="addtype-btn" type="button" class="btn btn-primary">Confirm</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>

           <!--edit modal-->
           <div class="modal fade" id="edittype_modal" tabindex="-1" role="dialog" aria-labelledby="newType" aria-hidden="true">
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
                                   <label for="exampleInputEmail1">Name</label>
                                   <input type="text" class="form-control" id="name" aria-describedby="" placeholder="">
                               </div>
                               <div class="form-group">
                                   <label for="exampleInputEmail1">Group</label>
                                   <input type="text" class="form-control" id="group" aria-describedby="" placeholder="">
                               </div>
                               <div class="form-group form-check">
                                   <input type="checkbox" class="form-check-input" id="ignore">
                                   <label class="form-check-label" for="ignore">Ignore GUI</label>
                               </div>
                               <div id="attr-action" class="form-group">
                                   <br/>
                                   <input type="text" id="attributes" name="attributes" hidden/>
                                   <a id="attr-add" style="" class="btn btn-warning">submit</a>
                                   <input id="attr-name" class="form-control"  style="" placeholder="name"/>
                                   <input id="attr-value" class="form-control"  style="" placeholder="value"/>
                                   <div id="list-attrs" class="form-group" style="border:1px solid grey;border-radius: 5px;">
                                       <ul>

                                       </ul>
                                   </div>
                               </div>
                           </form>
                           <div class="modal-footer">
                               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                               <button id="edittype-btn" type="button" class="btn btn-primary">Confirm</button>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
@stop

       @section('footerScript')
           <!-- Sweet-Alert  -->
               <script src="{{ URL::asset('plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
               <!-- Required datatable js -->
               <script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
               <script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
               <!-- Buttons examples -->
               <script src="{{ URL::asset('plugins/datatables/dataTables.buttons.min.js')}}"></script>
               <!-- Responsive examples -->
               <script src="{{ URL::asset('plugins/datatables/dataTables.responsive.min.js')}}"></script>
               <script src="{{ URL::asset('plugins/datatables/responsive.bootstrap4.min.js')}}"></script>
               <script src="{{ URL::asset('assets/pages/jquery.datatable.init.js')}}"></script>
               <script>
                   const delay = millis => new Promise((resolve, reject) => {
                       setTimeout(_ => resolve(), millis)
                   });

                   $('table').DataTable();

                   $(document).ready(function() {
                       var attrs = [];
                       var attrs2 = [];
                       var gid = 0;
                       $("#newtype_modal").on("click","#addtype-btn", function(event) {
                           event.preventDefault();
                           console.log("confirm clicked!");
                           var name = $("#newtype_modal #name").val();
                           var group = $("#newtype_modal #group").val();
                           var ig = false;
                           if ($("#newtype_modal #ignore").is(":checked"))
                           {
                               ig = true;
                           }else{
                               ig = false;
                           }
                           $.ajax({
                               type: "POST",
                               url: "/devicetype/add",
                               data: {
                                   _token: "{{csrf_token()}}",
                                   name: name,
                                   group: group,
                                   ignoreOnGUI: ig,
                                   params:  JSON.stringify(attrs),
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
                                           'New type added!',
                                           'success'
                                       )
                                       delayRedirect("/devices/types");

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
                                       url: "/devicetype/remove",
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
                                               delayRedirect("/devices/types");
                                           }else if(e.dismiss="cancel"){

                                           }else{
                                               Swal.fire(
                                                   'warning!',
                                                   "error occured!",
                                                   'warning'
                                               )
                                           }

                                       }
                                   });
                               }else{
                                   Swal.fire(
                                       'warning!',
                                        data.msg,
                                       'warning'
                                   )
                               }
                           });
                       });
                       $(".table").on("click",'#edit-item', function() {
                           gid = $(this).attr('data-button');
                           $.ajax({
                               type: "POST",
                               url: "/devicetype/get",
                               data: {
                                   _token: "{{csrf_token()}}",
                                   id: gid
                               },
                               success: function (data) {
                                   if(data.success){
                                       $("#edittype_modal #name").val(data.type.name);
                                       $("#edittype_modal #group").val(data.type.group);
                                       if(data.type.ignore){
                                           $("#edittype_modal #ignore").prop('checked', true);
                                       }else{
                                           $("#edittype_modal #ignore").prop('checked', false);
                                       }
                                       attrs2 = [];
                                       attrs2 = data.type.params;

                                       $("#edittype_modal #attr-action #list-attrs ul").empty();

                                       $.each(attrs2,function(i,v){
                                           var code = "<li><div><label class='attr-name'>"+v.name+"</label></div><div>";

                                           code+="<label> : " + v.max + "</label></div><a href='#' id='remove'>X</button></a></li>";

                                           $("#edittype_modal #attr-action #list-attrs ul").append(code);
                                       });
                                       $("#edittype_modal").modal('show');
                                   } else {

                                   }

                               }
                           });
                       });
                       $("#edittype_modal").on("click","#edittype-btn", function(event) {
                           event.preventDefault();
                           var name = $("#edittype_modal #name").val();
                           var group = $("#edittype_modal #group").val();
                           var ig = false;
                           if ($("#edittype_modal #ignore").is(":checked"))
                           {
                               ig = true;
                           }else{
                               ig = false;
                           }
                           $.ajax({
                               type: "POST",
                               url: "/devicetype/edit",
                               data: {
                                   _token: "{{csrf_token()}}",
                                   id: gid,
                                   name: name,
                                   group: group,
                                   ignoreOnGUI: ig,
                                   params: JSON.stringify(attrs2),
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
                                           'The type updated!',
                                           'success'
                                       )
                                       delayRedirect("/devices/types");
                                   }
                               }
                           });
                           return false;
                       });
                   $("#newtype_modal #attr-action #attr-add").on("click", function(){
                       attrs.push({name:$("#newtype_modal #attr-action #attr-name").val(), max:$("#newtype_modal #attr-action #attr-value").val()});
                       $("#newtype_modal #attr-action input#attributes").val(JSON.stringify(attrs));
                       console.log(JSON.stringify(attrs));
                       generateList(attrs);
                       return false;
                   });
                   $("#newtype_modal #attr-action #list-attrs ul").on("click","#remove", function(){
                       var i = $($(this).parent()).index();
                       delete attrs[i];
                       $(this).parent().remove();
                       attrs = attrs.filter(isNotNull);
                       console.log(JSON.stringify(attrs));
                       return false;
                   });
                       $("#edittype_modal #attr-action #attr-add").on("click", function(){
                           attrs2.push({name:$("#edittype_modal #attr-action #attr-name").val(), max:$("#edittype_modal #attr-action #attr-value").val()});
                           $("#edittype_modal #attr-action input#attributes").val(JSON.stringify(attrs2));
                           console.log(JSON.stringify(attrs2));
                           generateList(attrs2);
                           return false;
                       });
                       $("#edittype_modal #list-attrs ul").on("click","#remove", function(){
                           var i = $($(this).parent()).index();
                           delete attrs[i];
                           $(this).parent().remove();
                           attrs = attrs.filter(isNotNull);
                           console.log(JSON.stringify(attrs));
                           return false;
                       });
                   function generateList(data){
                       $("#attr-action #list-attrs ul").empty();

                       $.each(data,function(i,v){
                           var code = "<li><div><label class='attr-name'>"+v.name+"</label></div><div>";

                           code+="<label> : " + v.max + "</label></div><a href='#' id='remove'>X</button></a></li>";

                           $("#attr-action #list-attrs ul").append(code);
                       });
                   }
                   function isNotNull(value) {
                       return value != null;
                   }
                   });
               </script>
        @stop
