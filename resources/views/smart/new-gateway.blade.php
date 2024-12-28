@extends('layouts.project-master')

@section('title', 'Otomatic - smart cloud platform')

@section('headerStyle')
<link href="{{ URL::asset('plugins/animate/animate.css')}}" rel="stylesheet" type="text/css">
<link href="{{ URL::asset('assets/css/otomatic.css')}}" rel="stylesheet" type="text/css" />

@stop

@section('content')
 <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12">

                              @component('common-components.breadcrumb')
                                 @slot('title') New gateway @endslot
                                 @slot('item1') Home @endslot
                                 @slot('item2') Smart @endslot
                                 @endcomponent


                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <h4 class="page-title">Register your gateway</h4>
                                        <h6 class="mb-3 font-weight-normal text-muted">To add your gateway, the device must be on the same network. Please make sure your gateway is connect to your Router/Access-point like your system.</h6>
                                        <div id="animationSandbox">
                                            <div class="shadow-sm p-4 d-inline-block rounded-circle">
                                                    <img src="{{ URL::asset('assets/images/ip_con.png')}}" width="300" alt="" class="center-block">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-gradient-primary scan-btn">Scan network</button>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!-- container -->


 <!--edit modal-->
 <div class="modal fade" id="find_modal" tabindex="-1" role="dialog" aria-labelledby="newType" aria-hidden="true">
     <div class="modal-dialog" role="document">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title mt-0" id="exampleModalLabel">Finding gateway...</h5>
             </div>
             <div class="modal-body">
                 <div class="row">
                     <div class="col-12">
                         <div class="razar">
                             <div class="ringbase ring1"></div>
                             <div class="ringbase ring2"></div>
                             <div class="pulse"></div>
                             <div class="pointer">
                                 <div></div>
                             </div>
                             <div class="dot pos1"></div>
                             <div class="dot pos2"></div>
                         </div>
                         <div class="gateway-list" style="display: none;">
                            <div>
                                <img src="{{URL::asset('assets/images/ip_schem.png')}}" />
                            </div>
                             <div>
                                    <span class="model">XGIP.11</span>
                                    <span class="remark">BERXY</span>
                                    <span class="serial">6546546549878745</span>
                                 <span><button id="addgate-btn" type="button" style="margin: 0 auto;" class="btn btn-secondary btn-round waves-effect waves-light"><i class="mdi mdi-plus mr-2"></i>Add</button></span>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="modal-footer">
                     <button type="button" style="margin: 0 auto;" class="btn btn-gradient-purple" data-dismiss="modal">Cancel</button>

                 </div>
             </div>
         </div>
     </div>
 </div>
@stop

@section('footerScript')
<script src="{{ URL::asset('assets/pages/jquery.animate.init.js')}}"></script>
<script src="{{ URL::asset('plugins/sweet-alert2/sweetalert2.min.js')}}"></script>
    <script>
        var sn;
        $(".scan-btn").click(function(event) {
            $("#find_modal").modal({"backdrop": "static"});
            $("#find_modal .modal-title").html("Finding gateway...")
            $("#find_modal .razar").show();
            $("#find_modal .gateway-list").hide();
            checkIp();
        });

        function checkIp(){
            $.ajax({
                url: "/checkIp",
                type: 'GET',
                success: function(res) {
                    if(res.success){
                        showG(res);
                    }
                }
            });
        }
        async function showG(data){
            await sleep(2000);
            $("#find_modal .razar").fadeOut(300);
            sn = data.info["sn"];
            $("#find_modal .gateway-list .remark").html(data.info["remark"]);
            $("#find_modal .gateway-list .serial").html(data.info["sn"]);
            $("#find_modal .gateway-list").fadeIn(1000);
            $("#find_modal .modal-title").html("Founded!")
        }

        $("#addgate-btn").click(function(event) {
            $.ajax({
                url: "/verifyIp",
                type: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    id: sn
                },
                success: function(res) {
                    if(res.success==false){
                        Swal.fire(
                            'Warning!',
                            res.msg,
                            'warning'
                        )
                    } else if(res.success==true){
                        //Success Message
                        $('#find_modal').modal('hide');
                        Swal.fire(
                            'Successful!',
                            'Your gateway added successful!',
                            'success'
                        )
                        delayRedirect("/smart/gateways");
                    }
                }
            });
        });
        function sleep(ms) {
            return new Promise(resolve => setTimeout(resolve, ms));
        }
        async function delayRedirect(url){
            await delay(500);
            window.location.replace(url);
        }
    </script>
@stop
