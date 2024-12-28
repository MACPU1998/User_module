@extends('layouts.crypto-master')

@section('title', 'DigiBo')

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
                                 @slot('title') Exchange @endslot
                                 @slot('item1') Metrica @endslot
                                 @slot('item2') Crypto @endslot
                              @endcomponent

                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <button type="button" class="btn btn-outline-danger crypto-modal-btn" data-toggle="modal" data-target="#exampleModalSend"><i data-feather="navigation" class="align-self-center icon-md mr-2"></i>Send</button>
                                    <div class="modal fade" id="exampleModalSend" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultSend" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="exampleModalDefaultSend">Send Coin</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body">
                                                    <div class="auth-page">
                                                        <div class=" auth-card">
                                                            <div class="">
                                                                <div class="p-3">
                                                                    <form class="form-horizontal" action="/index">

                                                                        <div class="form-group">
                                                                            <label for="cryptocurrency">Crypto Currency</label>
                                                                            <select class="form-control">
                                                                                <option>-- Currency --</option>
                                                                                <option>BTC</option>
                                                                                <option>ETH</option>
                                                                            </select>
                                                                        </div><!--end form-group-->
                                                                        <div class="form-group">
                                                                            <label for="currencyfrom">Currency From</label>
                                                                            <select class="form-control">
                                                                                <option>-- My wallet --</option>
                                                                                <option>BTC</option>
                                                                                <option>ETH</option>
                                                                            </select>
                                                                        </div><!--end form-group-->


                                                                        <div class="form-group">
                                                                            <label for="toaddress">To</label>
                                                                            <div class="input-group mb-3">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text" id="QUCode"><i class="fas fa-qrcode"></i></span>
                                                                                </div>
                                                                                <input type="text" class="form-control" id="Scancode" placeholder="Can you scan">
                                                                            </div>
                                                                        </div><!--end form-group-->
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group row">
                                                                                    <label for="example-text-input" class="col-sm-2 col-form-label text-right">USD</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input class="form-control" type="text" placeholder="USD" id="USDCO">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group row">
                                                                                    <label for="example-text-input" class="col-sm-2 col-form-label text-right">BTC</label>
                                                                                    <div class="col-sm-10">
                                                                                        <input class="form-control" type="text" placeholder="BTC" id="BTCCO">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="message">Description</label>
                                                                            <textarea class="form-control" rows="3" id="Description"></textarea>
                                                                        </div><!--end form-group-->

                                                                        <div class="form-group mb-1">
                                                                            <div>
                                                                                <label for="NetworkFree">Network Free</label>
                                                                            </div>
                                                                            <div class="form-check-inline my-1">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" id="Regular" name="Networkfree" class="custom-control-input" checked>
                                                                                    <label class="custom-control-label" for="Regular">Regular</label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-check-inline my-1">
                                                                                <div class="custom-control custom-radio">
                                                                                    <input type="radio" id="Priority" name="Networkfree" class="custom-control-input">
                                                                                    <label class="custom-control-label" for="Priority">Priority</label>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--end form-group-->

                                                                        <div class="form-group mb-0 row">
                                                                            <div class="col-12 mt-2">
                                                                                <button class="btn btn-primary btn-rounded btn-block waves-effect waves-light py-2" type="text">Continue <i class="fas fa-sign-in-alt ml-1"></i></button>
                                                                            </div><!--end col-->
                                                                        </div> <!--end form-group-->
                                                                    </form><!--end form-->
                                                                </div><!--end /div-->

                                                            </div><!--end card-body-->
                                                        </div><!--end card-->

                                                    </div><!--end auth-page-->
                                                </div><!--end modal-body-->

                                            </div><!--end modal-content-->
                                        </div><!--end modal-dialog-->
                                    </div><!--end modal-->

                                    <button type="button" class="btn btn-outline-success crypto-modal-btn" data-toggle="modal" data-target="#exampleModalRequest"><i data-feather="download" class="align-self-center icon-md mr-2"></i>Request</button>
                                    <div class="modal fade" id="exampleModalRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalDefaultRequest" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title m-0" id="exampleModalDefaultRequest">Request Coin</h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true"><i class="la la-times"></i></span>
                                                    </button>
                                                </div><!--end modal-header-->
                                                <div class="modal-body">
                                                    <div class="auth-page">
                                                        <div class=" auth-card">
                                                            <div class="">
                                                                <div class="p-3">
                                                                    <form class="form-horizontal" action="/index">

                                                                        <div class="form-group">
                                                                            <label for="cryptocurrency">Crypto Currency</label>
                                                                            <select class="form-control">
                                                                                <option>-- Currency --</option>
                                                                                <option>BTC</option>
                                                                                <option>ETH</option>
                                                                            </select>
                                                                        </div><!--end form-group-->
                                                                        <div class="form-group">
                                                                            <label for="currencyReceive">Receive To</label>
                                                                            <select class="form-control">
                                                                                <option>-- My wallet --</option>
                                                                                <option>BTC</option>
                                                                                <option>ETH</option>
                                                                            </select>
                                                                        </div><!--end form-group-->


                                                                        <div class="form-group">
                                                                            <label for="toaddress">Address</label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control" id="W-Address" value="c12b001a15f9bd46ef1c6551386c">
                                                                                <div class="input-group-append">
                                                                                    <button class="btn btn-light shadow-none"><i class="fas fa-copy"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div><!--end form-group-->


                                                                        <div class="form-group mb-0 row">
                                                                            <div class="col-12 mt-2">
                                                                                <button class="btn btn-primary btn-rounded btn-block waves-effect waves-light py-2" type="text">Done <i class="fas fa-check ml-1"></i></button>
                                                                            </div><!--end col-->
                                                                        </div> <!--end form-group-->
                                                                    </form><!--end form-->
                                                                </div><!--end /div-->

                                                            </div><!--end card-body-->
                                                        </div><!--end card-->

                                                    </div><!--end auth-page-->
                                                </div><!--end modal-body-->

                                            </div><!--end modal-content-->
                                        </div><!--end modal-dialog-->
                                    </div><!--end modal-->
                                </div>
                                <div class="media">
                                    <img src="{{ URL::asset('assets/images/coins/btc.png')}}" class="mr-2 thumb-sm align-self-center rounded-circle" alt="...">
                                    <div class="media-body align-self-center">
                                        <p class="mb-1 text-muted">Total Balance</p>
                                        <h5 class="mt-0 text-dark mb-1">122.00125503 BTC</h5>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-3">Coin Market {{$time}}</h4>
                                    <div class="coin-market-nav">

                                                <ul class="list-unsyled m-0 pl-0">
{{--                                                    <li class="align-items-center d-flex justify-content-between py-1">--}}
{{--                                                        <a href="#" class="my-1"><img src="{{ URL::asset('assets/images/coins/btc.png')}}" alt="" class="mr-1" height="20">BTC-USD</a>--}}
{{--                                                        <span class="text-muted">$1420.00</span>--}}
{{--                                                        <span class="text-danger">-0.2%</span>--}}
{{--                                                    </li>--}}

                                                </ul>

                                    </div><!--end tab-content-->
{{--                                        <ul class="pagination pagination-sm justify-content-end mt-2 mb-0">--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">Previous</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">1</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">2</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">3</a></li>--}}
{{--                                            <li class="page-item"><a class="page-link" href="#">Next</a></li>--}}
{{--                                        </ul>--}}
                                    </div> <!--end balence-nav-->
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!-- container -->
@stop

@section('footerScript')
<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
{{--<script src="{{ URL::asset('assets/pages/jquery.crypto-exchange.init.js')}}"></script>--}}
    <script>
        $(document).ready(function () {

        });
        function cryptolist(data){
            $(".coin-market-nav .list-unsyled").empty();
            var r = data;
            r.forEach((e, i) => {
                var icon = '{{URL::asset("assets/images/coins")}}'+"/"+e.symbol+".png";
                var color = e.change_24h>0?"text-success":"text-danger";
                var codes = '<li class="align-items-center d-flex justify-content-between py-1">'+
                    "<a href='#' class='my-1'><img src='"+ icon +"' alt='' class='mr-1' height='20'>"+e.symbol+"-usd</a>" +
                    "<span class='text-muted'>"+e.price+"</span><span class='" + color + "'>" + e.change_24h +"</span></li>";

                $(".coin-market-nav .list-unsyled").append(codes);
            });
        }
        $.ajax({
            type: "GET",
            url: "/api/cryptoList",
            success: function (data) {
                cryptolist(data);
            }
        });
        var apifunc = function api(){
            $.ajax({
                type: "GET",
                url: "/api/cryptoList",
                success: function (data) {
                    cryptolist(data);
                }
            });
            console.log('read again!');
        }
        apifunc;


        setInterval(apifunc, 30000);
    </script>
@stop
