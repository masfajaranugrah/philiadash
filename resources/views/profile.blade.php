@extends('layouts.master')
@section('title')
    @lang('translation.profile')
@endsection
@section('css')
    <link href="{{ URL::asset('build/libs/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Pages
        @endslot
        @slot('title')
            Profile
        @endslot
    @endcomponent

    <div class="card">
        <div class="profile-foreground position-relative">
            <div class="profile-wid-bg position-static">
                @if (Auth::user()->foreground == null)
                <img src="build/images/small/img-3.jpg" class="profile-wid-img card-img-top">
                @else
                <img src="{{ asset('storage/foreground/' . Auth::user()->foreground) }}" class="profile-wid-img card-img-top">
    
                @endif
            </div>
            <div class="bg-overlay bg-primary bg-opacity-75 card-img-top"></div>
        </div>

        <div class="card-body mt-n5">
            <div class="position-relative mt-n3">
                <div class="avatar-lg position-relative">
                    @if (Auth::user()->profile == null)
                    <img src="build/images/users/avatar-4.jpg" 
                    alt="profile" 
                    class="img-thumbnail rounded-circle user-profile-image" 
                    style="width: 100px; height: 100px; object-fit: cover; object-position: center; z-index: 1;">
                        @else
                        <img src="{{ asset('storage/profile/' . Auth::user()->profile) }}" 
                        alt="{{ Auth::user()->profile }}" 
                        class="img-thumbnail rounded-circle user-profile-image" 
                        style="width: 100px; height: 100px; object-fit: cover; object-position: center; z-index: 1;">

                  
                    @endif
                  
                        
                </div>
                
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="mt-3">
                    <h3 class="fs-xl mb-1">{{ Auth::user()->firstname }}</h3>
                    {{-- <p class="fs-md text-muted mb-0">Owner & Founder</p> --}}
                </div>

                <div class="">
                    <a href="{{ route('user-setting') }}" class="btn btn-primary"><i class="ri-edit-box-line align-bottom"></i> Edit Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-body">
                    <div>
                        <h5 class="card-title mb-1">Details</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0 fs-md" scope="row">Full Name :</th>
                                        <td class="text-muted fs-sm">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 fs-md" scope="row">Mobile :</th>
                                        <td class="text-muted fs-sm">{{ Auth::user()->phone_number ? Auth::user()->phone_number : '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0 fs-md" scope="row">E-mail :</th>
                                        <td class="text-muted fs-sm">{{ Auth::user()->email }}</td>
                                    </tr>
                                     
                                </tbody>
                            </table>
                        </div>
                    </div>
           
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <!--end col-->

        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills nav-custom-outline nav-info profile-nav gap-2 gap-lg-3 flex-grow-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link fs-md active" data-bs-toggle="tab" href="#overview-tab" role="tab">
                                    <i class="ri-airplay-fill d-inline-block d-md-none"></i> <span class="d-none d-md-inline-block">Overview</span>
                                </a>
                            </li>
               
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tab panes -->
            <div class="tab-content text-muted">
                <div class="tab-pane active" id="overview-tab" role="tabpanel">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">About</h5>
                                    <p class="text-muted fs-md">{{ Auth::user()->description }}</p>
                                     
                                   
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div><!-- end card -->
 
                        </div>
                        <!--end col-->
                    </div>
                    <!--end row-->
                </div>
 
            </div>
            <!--end tab-content-->
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
