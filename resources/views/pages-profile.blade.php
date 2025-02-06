@extends('layouts.master')
@section('title')
@lang('translation.profile-settings')
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') Pages @endslot
@slot('title') Profile Settings @endslot
@endcomponent

 

<div class="card">
    <div class="profile-foreground position-relative">
        <div class="profile-wid-bg position-static">
            <img src="build/images/small/img-3.jpg" class="profile-wid-img card-img-top">
            {{-- <div>
                <input id="profile-foreground-img-file-input" type="file" class="profile-foreground-img-file-input d-none">
                <label for="profile-foreground-img-file-input" class="profile-photo-edit btn btn-light btn-sm position-absolute end-0 top-0 m-3 z-1">
                    <i class="ri-image-edit-line align-bottom me-1"></i> Edit Cover Images
                </label>
            </div> --}}
        </div>
        <div class="bg-overlay bg-primary bg-opacity-75 card-img-top"></div>
    </div>

    <div class="card-body mt-n5">
        <div class="position-relative mt-n3">
            <div class="avatar-lg position-relative">
                <img src="build/images/users/avatar-4.jpg" alt="user-img" class="img-thumbnail rounded-circle user-profile-image" style="z-index: 1;">
                {{-- <div class="avatar-xs p-0 rounded-circle profile-photo-edit position-absolute end-0 bottom-0">
                    <input id="profile-img-file-input" type="file" class="profile-img-file-input d-none">
                    <label for="profile-img-file-input" class="profile-photo-edit avatar-xs">
                        <span class="avatar-title rounded-circle bg-light text-body">
                            <i class="bi bi-camera"></i>
                        </span>
                    </label>
                </div> --}}
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <div class="mt-3">
                <h3 class="fs-xl mb-1">{{ Auth::user()->firstname }}</h3>
                {{-- <p class="fs-md text-muted mb-0">Owner & Founder</p> --}}
            </div>

            <div class="">
                <a href="{{ route('user') }}" class="btn btn-primary"><i class="ri-edit-box-line align-bottom"></i>Lihat Profile</a>
            </div>
        </div>
    </div>
</div>

<div class="row">

    <!--end col-->
    <div class="col-xl-9">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-pills nav-custom-outline nav-info gap-2 flex-grow-1 mb-0" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link fs-md active" data-bs-toggle="tab" href="#personalDetails" role="tab" aria-selected="true">
                            Personal Details
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link fs-md" data-bs-toggle="tab" href="#changePassword" role="tab" aria-selected="false" tabindex="-1">
                            Changes Password
                        </a>
                    </li>
                   
                     
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="tab-content">

                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Personal Details</h6>
                    </div>
                    <div class="card-body">
                          <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                            <div class="row">
                                <!-- First Name -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="firstnameInput" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="firstnameInput" name="firstname" 
                                            placeholder="Enter your first name" value="{{ Auth::user()->firstname ? Auth::user()->firstname : '-' }}" >
                                    </div>
                                </div>
                        
                                <!-- Last Name -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="lastnameInput" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="lastnameInput" name="lastname" 
                                            placeholder="Enter your last name" value="{{ Auth::user()->lastname  ? Auth::user()->lastname : '-' }}" >
                                    </div>
                                </div>
                        
                                <!-- Email Address -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="emailInput" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="emailInput" name="email" 
                                            placeholder="Enter your email" value="{{ Auth::user()->email ? Auth::user()->email : '-'}}" >
                                    </div>
                                </div>
                        
                                <!-- Phone Number -->
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="phonenumberInput" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="phonenumberInput" name="phone_number" 
                                            placeholder="Enter your phone number" value="{{ Auth::user()->phone_number ? Auth::user()->phone_number : '-' }}" 
                                            pattern="^\+?\d{10,15}$" >
                                    </div>
                                </div>
                        
                                <!-- Description -->
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label for="descriptionInput" class="form-label">Description</label>
                                        <textarea class="form-control" id="descriptionInput" name="description" rows="5" 
    placeholder="Enter your description" required>{{ Auth::user()->description ? Auth::user()->description : '-' }}</textarea>

                                    </div>
                                </div>
                        
                                <!-- Buttons -->
                                <div class="col-lg-12">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="reset" class="btn btn-danger">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </form> 
                        
                    </div>
                </div>
                <!--end tab-pane-->
                <div class="tab-pane" id="changePassword" role="tabpanel">
                    <div class="card-header">
                        <h6 class="card-title mb-0">Changes Password</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reset', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                     
                            <div class="row g-2 justify-content-lg-between align-items-center">
                                <div class="col-lg-4">
                                    <div class="auth-pass-inputgroup">
                                        <label for="oldpasswordInput" class="form-label fs-md">Old Password*</label>
                                        <div class="position-relative">
                                            <input type="password" name="password" class="form-control fs-md password-input" id="oldpasswordInput" placeholder="Enter current password">
                                            <button class="btn btn-link shadow-none position-absolute top-0 end-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="auth-pass-inputgroup">
                                        <label for="password-input" class="form-label fs-md">New Password*</label>
                                        <div class="position-relative">
                                            <input type="password"  name="new-password" class="form-control password-input fs-md" id="password-input" onpaste="return false" placeholder="Enter new password" aria-describedby="passwordInput" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
                                            <button class="btn btn-link shadow-none position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="auth-pass-inputgroup">
                                        <label for="confirm-password-input" class="form-label fs-md">Confirm Password*</label>
                                        <div class="position-relative">
                                            <input type="password" name="current_password" class="form-control password-input fs-md" onpaste="return false" id="confirm-password-input" placeholder="Confirm password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"  required>
                                            <button class="btn btn-link shadow-none position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                     <div class="">

                                        <button type="submit" class="btn btn-info">Change Password</button>
                                    </div>
                                </div>

                                <!--end col-->

                                <div class="col-lg-12">
                                    <div class="card bg-light shadow-none passwd-bg" id="password-contain">
                                        <div class="card-body">
                                            <div class="mb-4">
                                                <h5 class="fs-sm">Password must contain:</h5>
                                            </div>
                                            <div class="">
                                                <p id="pass-length" class="invalid fs-xs mb-2">Minimum <b>8 characters</b></p>
                                                <p id="pass-lower" class="invalid fs-xs mb-2">At <b>lowercase</b> letter (a-z)</p>
                                                <p id="pass-upper" class="invalid fs-xs mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                                <p id="pass-number" class="invalid fs-xs mb-0">A least <b>number</b> (0-9)</p>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!--end row-->
                        </form>
                 
                    </div>
                </div>
               
              
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->



 
@endsection
@section('script')
<script src="{{ URL::asset('build/js/pages/passowrd-create.init.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/profile-setting.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
