@extends("admin.layout.master")
@section("page_title",__('general.dashboard'))
@section('content')
<div class="container-xxl flex-grow-1 container-p-y dashboard-index">
    <div class="row">
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-3">
              <span class="avatar-initial rounded-circle bg-label-primary"><i class="fa-solid fa-user-clock"></i></span>
            </div>
            <span class="d-block mb-1 text-nowrap"><a href="{{$pending_users['url']}}">تعداد مجریان در انتظار بررسی</a></span>
            <h2 class="mb-n3">{{$pending_users["data"]}}</h2>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-3">
              <span class="avatar-initial rounded-circle bg-label-success"><i class="fa-solid fa-user-check"></i></span>
            </div>
            <span class="d-block mb-1 text-nowrap"><a href="{{$accepted_users['url']}}">تعداد مجریان تایید شده</a></span>
            <h2 class="mb-n3">{{$accepted_users['data']}}</h2>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-3">
              <span class="avatar-initial rounded-circle bg-label-warning"><i class="fa-solid fa-user-xmark"></i></span>
            </div>
            <span class="d-block mb-1 text-nowrap"><a href="{{$rejected_users['url']}}">تعداد مجریان رد شده</a></span>
            <h2 class="mb-n3">{{$rejected_users['data']}}</h2>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
        <div class="card">
          <div class="card-body text-center">
            <div class="avatar avatar-md mx-auto mb-3">
              <span class="avatar-initial rounded-circle bg-label-danger"><i class="fa-solid fa-user-lock"></i></span>
            </div>
            <span class="d-block mb-1 text-nowrap"><a href="{{$block_users['url']}}">تعداد مجریان مسدود شده</a></span>
            <h2 class="mb-n3">{{$block_users['data']}}</h2>
          </div>
        </div>
      </div>

        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-primary"><i class="fa-solid fa-diagram-project"></i></span>
                    </div>
                    <span class="d-block mb-1 text-nowrap"><a href="{{$pending_projects['url']}}">تعداد پروژه های در انتظار بررسی</a></span>
                    <h2 class="mb-n3">{{$pending_projects['data']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-success"><i class="fa-solid fa-diagram-project"></i></span>
                    </div>
                    <span class="d-block mb-1 text-nowrap"><a href="{{$accepted_projects['url']}}">تعداد پروژه های تایید شده</a></span>
                    <h2 class="mb-n3">{{$accepted_projects['data']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-warning"><i class="fa-solid fa-diagram-project"></i></span>
                    </div>
                    <span class="d-block mb-1 text-nowrap"><a href="{{$rejected_projects['url']}}">تعداد پروژه رد شده</a></span>
                    <h2 class="mb-n3">{{$rejected_projects['data']}}</h2>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12  mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <div class="avatar avatar-md mx-auto mb-3">
                        <span class="avatar-initial rounded-circle bg-label-danger"><i class="fa-solid fa-diagram-project"></i></span>
                    </div>
                    <span class="d-block mb-1 text-nowrap"><a href="{{$block_projects['url']}}">تعداد پروژه های برای بازبینی</a></span>
                    <h2 class="mb-n3">{{$block_projects['data']}}</h2>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
