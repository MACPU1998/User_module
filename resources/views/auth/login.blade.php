@extends('layouts.authLayout')
@section('title', 'صفحه ورود ')

@section('content')

    <!-- Preloader -->
    <div class="preloader">
        <img src="../assets/images/logos/favicon.png" alt="loader" class="lds-ripple img-fluid"/>
    </div>
    <!-- Log In page -->
    <div id="main-wrapper">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100 w-100">
            <div class="position-relative z-index-5">
                <div class="row gx-0">

                    <div class="col-lg-6 col-xl-5 col-xxl-4">
                        <div class="min-vh-100 bg-body row justify-content-center align-items-center p-5">
                            <div class="col-12 auth-card">
                                <a href="/" class="text-nowrap  d-block w-100"><img
                                        src="{{ URL::asset('assets/images/logos/logo.svg') }}" height="55" alt="logo"
                                        class="auth-logo"></a>
                                <h2 class="mb-2 mt-4 fs-7 fw-bolder">صفحه ورود</h2>
                                <p class="mb-9">برای ادامه به دنیای iOT خود وارد شوید.</p>
                                <!-- <div class="row">
                              <div class="col-6 mb-2 mb-sm-0">
                                <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                                  <img src="../assets/images/svgs/google-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18" />
                                  Google
                                </a>
                               </div>
                             <div class="col-6">
                                <a class="btn btn-link border border-muted d-flex align-items-center justify-content-center rounded-2 py-8 text-decoration-none" href="javascript:void(0)" role="button">
                                  <img src="../assets/images/svgs/facebook-icon.svg" alt="matdash-img" class="img-fluid me-2" width="18" height="18" />
                                  Facebook
                                </a>
                              </div>
                            </div> -->
                                <!-- <div class="position-relative text-center my-4">
                                <p class="mb-0 fs-4 px-3 d-inline-block bg-body text-dark z-index-5 position-relative">
                                  or sign in with
                                </p>
                                <span class="border-top w-100 position-absolute top-50 start-50 translate-middle"></span>
                              </div> -->
                                <form method="POST" action="{{route('login')}}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">ایمیل</label>
                                        <input id="email" type="email" class="form-control " name="email"
                                               value="" placeholder="لطفا ایمیل خود را وارد کنید" value="" required
                                               autocomplete="email" autofocus>

                                    </div>
                                    <div class="mb-4">
                                        <label for="password" class="form-label">رمز عبور</label>
                                        <input id="password" type="password"
                                               placeholder="لطفا رمز عبور خود را وارد کنید"
                                               class="form-control " name="password" required
                                               autocomplete="current-password">

                                    </div>
                                    <div class="d-sm-flex align-items-center justify-content-between mb-4">

                                        <div class="form-check custom-control custom-switch switch-success">
                                            <input class="form-check-input primary" type="checkbox" name="remember"
                                                   id="customSwitchSuccess">

                                            <label class="custom-control-label text-muted" for="customSwitchSuccess">
                                                این
                                                دستگاه را به خاطر بسپارید
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 py-8 mb-4 rounded-2">ورود
                                    </button>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <p class="fs-4 mb-0 fw-medium">حساب کاربری ندارید ؟</p>
                                        <a class="text-primary fw-medium ms-2" href="{{ route('register') }}">ساخت حساب
                                            جدید</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div
                        class="col-lg-6 col-xl-7 col-xxl-8 position-relative overflow-hidden bg-dark d-none d-lg-block">
                        <div class="circle-top"></div>
                        <div>
                            <img src="../assets/images/logos/logo-icon.svg" class="circle-bottom" alt="Logo-Dark"/>
                        </div>
                        <div class="d-lg-flex align-items-center z-index-5 position-relative h-n80">
                            <div class="row justify-content-center w-100">
                                <div class="col-lg-6">
                                    <h2 class="text-white fs-10 mb-3 lh-base">
                                        خوش آمدید به
                                        <br/>
                                        رایکاآیو
                                    </h2>
                                    <span class="opacity-75 fs-4 text-white d-block mb-3">لورم ایپسوم متن ساختگی با تولید
                                        سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه
                                        روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد
                                        نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد.
                                    </span>
                                    <a href="" class="btn btn-primary">بیشتر بدانید</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end container-->
    <!-- End Log In page -->
    <div class="dark-transparent sidebartoggler"></div>

@endsection
