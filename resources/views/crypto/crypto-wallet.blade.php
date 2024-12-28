@extends('layouts.crypto-master')

@section('title', 'Metrica - Admin & Dashboard Template')

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
                                 @slot('title') Wallet @endslot
                                 @slot('item1') Metrica @endslot
                                 @slot('item2') Crypto @endslot
                              @endcomponent

                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        @if($user->wallet_id!=null)
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
                                                                                        <input class="form-control" type="text" placeholder="USD"" id="USDCO">
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
                        @endif
                    </div><!--end row-->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12 col-xl-12">
                                    <div class="card">
                                        <div class="card-body pb-0">
                                            <h4 class="header-title mt-0">Today's Rate</h4>
                                        </div>
                                        <div class="card-body text-center px-5 pb-5">
                                            <img src="{{ URL::asset('assets/images/coins/btc.png')}}" alt="" class="thumb-lg">
                                            <div class="my-4">
                                                <h2 class="font-24">$8172.60</h2>
                                                <p class="text-muted mb-3">
                                                        There are many variations of passages of Lorem Ipsum available.
                                                </p>
                                            </div>
                                            <button type="button" class="btn btn-soft-warning shadow-none px-5">Buy Coins</button>
                                        </div><!--end card-body-->
                                    </div><!--end card-->
                                </div><!--end col-->

                            </div><!--end row-->
                            <div class="card">
                                <div class="card-body">

                                    <div class="table-responsive dash-social">
                                        <table id="datatable" class="table table-bordered">
                                            <thead class="thead-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Transaction ID</th>
                                                <th>Type</th>
                                                <th>Value</th>
                                            </tr><!--end tr-->
                                            </thead>

                                            <tbody>
                                            <tr>
                                                <td>01</td>
                                                <td>14 Jan 2019</td>
                                                <td>12:05PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$521.36</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>02</td>
                                                <td>13 Jan 2019</td>
                                                <td>10:15AM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-success">Received</span></td>
                                                <td>$990.00</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>03</td>
                                                <td>11 Jan 2019</td>
                                                <td>09:14PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$321.21</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>04</td>
                                                <td>08 Jan 2019</td>
                                                <td>12:05PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-success">Received</span></td>
                                                <td>$321.21</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>05</td>
                                                <td>06 Jan 2019</td>
                                                <td>11:30AM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$458.80</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>06</td>
                                                <td>05 Jan 2019</td>
                                                <td>05:50PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-success">Received</span></td>
                                                <td>125.50</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>07</td>
                                                <td>04 Jan 2019</td>
                                                <td>08:10PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$365.21</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>08</td>
                                                <td>03 Jan 2019</td>
                                                <td>01:30PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-success">Received</span></td>
                                                <td>$843.21</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>09</td>
                                                <td>03 Jan 2019</td>
                                                <td>12:05PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$335.15</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>10</td>
                                                <td>02 Jan 2019</td>
                                                <td>03:15PM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-success">Received</span></td>
                                                <td>$554.50</td>
                                            </tr><!--end tr-->
                                            <tr>
                                                <td>11</td>
                                                <td>01 Jan 2019</td>
                                                <td>10:05AM</td>
                                                <td>c12b001a15f9bd46ef1c6551386c6a2bcda1ab3eae5091fba</td>
                                                <td><span class="badge badge-soft-danger">Sent</span></td>
                                                <td>$225.25</td>
                                            </tr><!--end tr-->

                                            </tbody>
                                        </table>
                                    </div>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!-- container -->
@stop

@section('footerScript')
<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL::asset('plugins/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script>
     $('#datatable').DataTable();
</script>
@stop
