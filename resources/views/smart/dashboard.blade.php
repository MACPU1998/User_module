@extends('layouts.project-master')

@section('title', 'Otomatic - smart cloud platform')

@section('content')
    <div class="container-fluid">
                    <!-- Page-Title -->
                    <div class="row">
                        <div class="col-sm-12" style="padding: 15px">

{{--                             @component('common-components.breadcrumb')--}}
{{--                                 @slot('title') dashboard  @endslot--}}
{{--                                 @slot('item1') home @endslot--}}
{{--                                 @slot('item2')  @endslot--}}
{{--                            @endcomponent--}}
                        <span class=""></span>
                        </div><!--end col-->
                    </div>
                    <!-- end page title end breadcrumb -->
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">

  @component('common-components.project-widget')
     @slot('iconClass') align-self-center icon-lg icon-dual-warning  @endslot
     @slot('title') Projects  @endslot
     @slot('cost') 0 @endslot
     @slot('pClass') progress-bar bg-warning @endslot
     @slot('pCost') 0 @endslot
 @endcomponent

   @component('common-components.project-widget')
     @slot('iconClass') align-self-center icon-lg icon-dual-success  @endslot
     @slot('title') Devices  @endslot
     @slot('cost') 0 @endslot
     @slot('headClass') d-inline-block @endslot
     @slot('pClass') progress-bar bg-success @endslot
     @slot('isActive') true @endslot
     @slot('pCost') 0 @endslot
 @endcomponent


   @component('common-components.project-widget')
     @slot('iconClass') align-self-center icon-lg icon-dual-purple  @endslot
     @slot('title') Gateways  @endslot
     @slot('cost') 0 @endslot
     @slot('pClass') progress-bar bg-purple @endslot
     @slot('pCost') 0 @endslot
 @endcomponent



                            </div><!--end row-->
                            </div><!--end col-->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="center">Banner</h4>
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->

                    </div><!--end row-->


                    <div class="row">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title mt-0 mb-4">Activity</h4>
                                    <div class="slimscroll crm-dash-activity">
                                        <div class="activity">
{{--                                            <div class="activity-info">--}}
{{--                                                <div class="icon-info-activity">--}}
{{--                                                    <i class="mdi mdi-checkbox-marked-circle-outline bg-soft-success"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="activity-info-text">--}}
{{--                                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                        <h6 class="m-0 w-75">Task finished</h6>--}}
{{--                                                        <span class="text-muted d-block font-12">10 Min ago</span>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-3">There are many variations majority have suffered alteration.--}}
{{--                                                        <a href="#" class="text-info">[more info]</a>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="activity-info">--}}
{{--                                                <div class="icon-info-activity">--}}
{{--                                                    <i class="mdi mdi-timer-off bg-soft-pink"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="activity-info-text">--}}
{{--                                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                        <h6 class="m-0  w-75">Task Overdue</h6>--}}
{{--                                                        <span class="text-muted font-12">50 Min ago</span>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-3">There are many variations majority have suffered alteration.--}}
{{--                                                        <a href="#" class="text-info">[more info]</a>--}}
{{--                                                    </p>--}}
{{--                                                    <span class="badge badge-soft-secondary">Design</span>--}}
{{--                                                    <span class="badge badge-soft-secondary">HTML</span>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="activity-info">--}}
{{--                                                <div class="icon-info-activity">--}}
{{--                                                    <i class="mdi mdi-alert-decagram bg-soft-purple"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="activity-info-text">--}}
{{--                                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                        <h6 class="m-0  w-75">New Task</h6>--}}
{{--                                                        <span class="text-muted font-12">10 hours ago</span>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-3">There are many variations majority have suffered alteration.--}}
{{--                                                        <a href="#" class="text-info">[more info]</a>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}

{{--                                            <div class="activity-info">--}}
{{--                                                <div class="icon-info-activity">--}}
{{--                                                    <i class="mdi mdi-clipboard-alert bg-soft-warning"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="activity-info-text">--}}
{{--                                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                        <h6 class="m-0">New Comment</h6>--}}
{{--                                                        <span class="text-muted font-12">Yesterday</span>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-3">There are many variations majority have suffered alteration.--}}
{{--                                                        <a href="#" class="text-info">[more info]</a>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="activity-info">--}}
{{--                                                <div class="icon-info-activity">--}}
{{--                                                    <i class="mdi mdi-clipboard-alert bg-soft-secondary"></i>--}}
{{--                                                </div>--}}
{{--                                                <div class="activity-info-text">--}}
{{--                                                    <div class="d-flex justify-content-between align-items-center">--}}
{{--                                                        <h6 class="m-0">New Lead Miting</h6>--}}
{{--                                                        <span class="text-muted font-12">14 Nov 2019</span>--}}
{{--                                                    </div>--}}
{{--                                                    <p class="text-muted mt-3">There are many variations majority have suffered alteration.--}}
{{--                                                        <a href="#" class="text-info">[more info]</a>--}}
{{--                                                    </p>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        </div><!--end activity-->
                                    </div><!--end crm-dash-activity-->
                                </div>  <!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 mb-3 header-title">All Projects</h4>
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Project Name</th>
                                                    <th>Client Name</th>
                                                    <th>Create Date</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Sama building</td>
                                                    <td>
                                                        <img src="{{ URL::asset('assets/images/users/user-2.jpg')}}" alt="" class="thumb-sm rounded-circle mr-2">
                                                        Kevin J. Heal
                                                    </td>
                                                    <td>20/3/2018</td>
                                                    <td><span class="badge badge-md badge-boxed  badge-soft-success">Active</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="text-right">
                                            <a href="#" class="">View All<i class="dripicons-arrow-thin-right ml-2"></i></a>
                                        </div>
                                    </div><!--end table-responsive-->
                                </div><!--end card-body-->
                            </div><!--end card-->
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!-- container -->
@stop

@section('footerScript')
        <script src="{{ URL::asset('assets/pages/jquery.projects-index.init.js')}}"></script>
@stop
