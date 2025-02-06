@extends('layouts.master')
@section('title')
@lang('translation.dashboards')
@endsection
@section('content')
<body class="dashboard-topbar-wrapper">
<div class="row">
    <div class="col-xl-8">
        <div>
            <div class="row gy-4">
            
                <div class="col-sm-4 ">
                    <div class="text-center">
                        <p class="text-uppercase fw-medium text-muted text-truncate fs-md">Trafic</p>
                        
                    </div><!-- end card -->
                </div>
                
            </div>

            <div class="mt-4">
                <div class="mx-n4">
                    <div id="performance_overview" data-colors='["--tb-primary", "--tb-warning"]' class="apex-charts" dir="ltr"></div>
                </div>
            </div>
 

            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-height-100">
                        <div class="card-header d-flex align-items-center">
                            <h6 class="card-title flex-grow-1 mb-0">Session by Device Type</h6>
                           
                        </div>
                        <div class="card-body">
                             <p class="text-muted">Total Device website visitor</p>
                            <div class="progress mb-4" style="height: 34px;">
                                <div class="progress-bar" data-bs-toggle="tooltip" data-bs-title="Mobile" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-success" data-bs-toggle="tooltip" data-bs-title="Tables" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-info" data-bs-toggle="tooltip" data-bs-title="Laptop" role="progressbar" style="width: 37%" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100"></div>
                                <div class="progress-bar bg-warning" data-bs-toggle="tooltip" data-bs-title="Others" role="progressbar" style="width: 8%" aria-valuenow="8" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
            
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="card border-4 border-bottom border-primary mb-0">
                                        <div class="card-body text-center">
                                            <h6 class="fs-lg mb-2"><span class="counter-value" data-target="{{ $mobileCount }}">0</span></h6>
                                            <p class="mb-0 fs-md text-muted">Mobile</p>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-sm-6">
                                    <div class="card border-4 border-bottom border-success mb-0">
                                        <div class="card-body text-center">
                                            <h6 class="fs-lg mb-2"><span class="counter-value" data-target="{{ $tabletCount }}">0</span></h6>
                                            <p class="mb-0 fs-md text-muted">Tables</p>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                                <div class="col-sm-6">
                                    <div class="card border-4 border-bottom border-info mb-0">
                                        <div class="card-body text-center">
                                            <h6 class="fs-lg mb-2"><span class="counter-value" data-target="{{ $desktopCount }}">0</span></h6>
                                            <p class="mb-0 fs-md text-muted">Laptop</p>
                                        </div>
                                    </div>
                                </div>
                                <!--end col-->
                               
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                </div>
            </div>
                              
        </div>
    </div>
    <!--end col-->
    <div class="col-xl-4">
        <div class="d-none d-xl-block">
            <div class="card bg-success-subtle shadow-none rounded-0 border-0 dashboard-widgets-wrapper">
                <div class="card-body text-center mt-5 pt-5">
                    <h5>Welcome to Astheron Technologies</h5>
                    <p class="text-muted fs-md  ">You will get the latest updates from us
                    </p>
                    <img src="build/images/dashboard.png" alt="" class="img-fluid">
                </div>
            </div>
        </div>
        <div class="mt-xl-5 pt-xl-4">
       
            <div class="card">
                <div class="card-header d-flex">
                    <h5 class="card-title flex-grow-1 mb-0">Upcoming Schedule</h5>
                   
                </div>
                <div class="card-body vstack gap-2">

                    @foreach ( $event as $items )
                         <div class="d-flex bg-body-secondary rounded">
                        <div class="flex-shrink-0 w-md py-2 px-3 text-center border-end">
                            <p class="mb-1 text-muted fs-sm">
                                @if (\Carbon\Carbon::parse($items->start)->format('Y-m-d') === \Carbon\Carbon::parse($items->end)->format('Y-m-d'))
                                    {{ \Carbon\Carbon::parse($items->start)->format('D, d M') }}
                                @else
                                    {{ \Carbon\Carbon::parse($items->start)->format('D, d M') }} <br/> {{ \Carbon\Carbon::parse($items->end)->format('D, d M') }}
                                @endif
                            </p>
                            <h6 class="mb-0">
                                @if (\Carbon\Carbon::parse($items->start)->format('h:i A') === \Carbon\Carbon::parse($items->end)->format('h:i A'))
                                {{ \Carbon\Carbon::parse($items->start)->format('h:i A') }}
                            @else
                                {{ \Carbon\Carbon::parse($items->start)->format('h:i A') }} <br/> {{ \Carbon\Carbon::parse($items->end)->format('h:i A') }}
                            @endif
                            </h6>

                        </div>
                        <div class="flex-grow-1 px-3 py-2 overflow-hidden">
                            <h6>{{ $items->title }}</h6>
                            <p class="text-muted fs-sm text-truncate mb-0">{{  $items->description }}</p>
                        </div>
                    </div>
              
                    @endforeach
                  
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

 
<!--end row-->
@endsection

@section('script')
<!-- apexcharts -->
<script src="{{ URL::asset('build/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- dashboard init -->
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/js/pages/dashboard-analytics.init.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection

