@extends('layouts.master-without-nav')
@section('title')
@lang('translation.signin')
@endsection
@section('content')

<section class="auth-page-wrapper py-5 position-relative bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card mb-0">
                    <div class="card-body">
                        <div class="row g-0 align-items-center">
                            <div class="col-xxl-6 mx-auto">
                                <div class="card mb-0 border-0 shadow-none mb-0">
                                    <div class="card-body p-sm-5 m-lg-4">
                                        <div class="text-center mt-5">
                                            <h5 class="fs-3xl">Welcome Back</h5>
                                            <p class="text-muted">Sign in to continue to dash.</p>
                                        </div>
                                        <div class="p-2 mt-5">
                                            <form action="{{ route('login')}}" method="post">
                                                @csrf
                                                <div class="mb-3">
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="basic-addon"><i class="ri-user-3-line"></i></span>
                                                        <input type="text" class="form-control @error('email') is-invalid @enderror" id="username"  name="email" value="{{ old('email', 'admin@sss.com') }}" placeholder="Enter username">
                                                        @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <div class="position-relative auth-pass-inputgroup overflow-hidden">
                                                        <div class="input-group">
                                                            <span class="input-group-text" id="basic-addon1"><i class="ri-lock-2-line"></i></span>
                                                            <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" placeholder="Enter password" id="password-input" name="password"  value="Joker12@">
                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>
                                                        <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                    </div>
                                                </div>
                                                <div class="float-end">
                                                    <a href="auth-pass-reset" class="text-muted">Forgot password?</a>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value="" id="auth-remember-check">
                                                    <label class="form-check-label" for="auth-remember-check">Remember me</label>
                                                </div>
                                                <div class="mt-4">
                                                    <button class="btn btn-primary w-100" type="submit">Sign In</button>
                                                </div>
                                                <div class="mt-4 pt-2 text-center">
                                                    <div class="signin-other-title position-relative">
                                                        <h5 class="fs-sm mb-4 title">Sign In with</h5>
                                                    </div>
                                                    <div class="pt-2 hstack gap-2 justify-content-center">
                                                        <button type="button" class="btn btn-subtle-primary btn-icon"><i class="ri-facebook-fill fs-lg"></i></button>
                                                        <button type="button" class="btn btn-subtle-danger btn-icon"><i class="ri-google-fill fs-lg"></i></button>
                                                        <button type="button" class="btn btn-subtle-dark btn-icon"><i class="ri-github-fill fs-lg"></i></button>
                                                        <button type="button" class="btn btn-subtle-info btn-icon"><i class="ri-twitter-fill fs-lg"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="text-center mt-5">
                                                <p class="mb-1">Don't have an account yet?</p>
                                                <a href="register" class="text-secondary text-decoration-underline"> Create an account</a>
                                            </div>
                                        </div>
                                    </div><!-- end card body -->
                                </div><!-- end card -->
                            </div>
                           
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
</section>
@endsection
@section('script')

<script src="{{ URL::asset('build/js/pages/password-addon.init.js') }}"></script>
<script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/swiper.init.js') }}"></script>

@endsection
