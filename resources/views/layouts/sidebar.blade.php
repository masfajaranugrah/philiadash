<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <a   class="logo logo-dark">
            <span class="logo-sm">
                <h1 class="text-white">PH</h1>
            </span>
            <span class="logo-lg">
                <h1 class="text-white">PH</h1>
            </span>
        </a>
        <a   class="logo logo-light">
            <span class="logo-sm">
                <h1 class="text-white">PH</h1>
            </span>
            <span class="logo-lg">
                <h1 class="text-white">PH</h1>
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-3xl header-item float-end btn-vertical-sm-hover shadow-none" id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">

                <li class="menu-title"><span data-key="t-menu">@lang('translation.menu')</span></li>
               
           

                <li class="nav-item">
                    <a href="{{ route('dash') }}" class="nav-link menu-link">  <i class="ti ti-brand-google-home"></i> <span data-key="t-chat">Dashboard</span> </a>
                </li>

                <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">Kegiatan</span></li>

                <li class="nav-item">
                    <a href="{{ route('whats') }}" class="nav-link menu-link"> <i class="ti ti-address-book"> </i><span data-key="t-calendar">Kegiatan</span> </a>
                </li>
                <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">Wahana</span></li>

             

                <li class="nav-item">
                    <a href="{{ route('wahana') }}" class="nav-link menu-link"> <i class="ti ti-photo"></i> <span data-key="t-chat">Wahana</span> </a>
                </li>

                <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">FAQ</span></li>

                 <li class="nav-item">
                    <a href="{{ route('question') }}" class="nav-link menu-link"> <i class="ti ti-messages"></i> <span data-key="t-email">FAQ</span> </a>
                </li>
                <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">Calender</span></li>

                <li class="nav-item">
                    <a href="{{ route('event') }}" class="nav-link menu-link"> <i class="ti ti-calendar"></i> <span data-key="t-calendar">Calender</span> </a>
                </li>

                <li class="menu-title"><i class="ti ti-dots"></i> <span data-key="t-apps">User</span></li>

                <li class="nav-item">
                    <a href="{{ route('user') }}" class="nav-link menu-link"> <i class="ti ti-user-circle"> </i><span data-key="t-calendar">User</span> </a>
                </li>
                

                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>