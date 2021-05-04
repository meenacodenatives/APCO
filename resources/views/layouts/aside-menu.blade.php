<!--APP-SIDEBAR-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="side-header">
        <a class="header-brand1" href="{{url('/' . $page='dashboard')}}">
            <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{URL::asset('assets/images/brand/logo-1.png')}}" class="header-brand-img toggle-logo" alt="logo">
                    <img src="{{URL::asset('assets/images/brand/logo-2.png')}}" class="header-brand-img light-logo" alt="logo">
                        <img src="{{URL::asset('assets/images/brand/logo-3.png')}}" class="header-brand-img light-logo1" alt="logo">
                            </a><!-- LOGO -->
                            </div>
                            <ul class="side-menu">

                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/dashboard')}}">
                                        <i class="ti-home"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Dashboard</span>
                                    </a>
                                </li>
                                
                                 <li class="slide">
                                    <a class="side-menu__item" href="{{url('/schedular')}}">
                                        <i class="mdi mdi-alarm-multiple"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Schedular</span>
                                    </a>
                                </li>

                                <li>
                                    <h3>CRM</h3>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/leads')}}">
                                        <!--<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3" />
                                            <path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" /></svg>
                                        -->
                                        <i class="ti-user"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Lead</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='showRFQ')}}">

                                        <i class="ti-user"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">RFQ</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item"  href="{{url('/' . $page='showSales')}}">
                                        <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3" />
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
                                            <circle cx="12" cy="9" r="2.5" /></svg> -->
                                        
                                        <i class="ti-headphone-alt"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Sales</span>
                                    </a>
                                   
                                </li>
                                
                                <li>
                                    <h3>Product</h3>
                                </li>
                                
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/showProduct')}}">
                                        <!--<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3" />
                                            <path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" /></svg>
                                        -->
                                        <i class="ti-user"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Product Inventory</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='showCategory')}}">
                                        <!--<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3" />
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
                                            <circle cx="12" cy="9" r="2.5" /></svg>
                                        -->
                                        <i class="ti-user"></i> &nbsp;&nbsp;
                                        <span class="side-menu__label">Category</span>
                                    </a>
                                </li>
                                
                                <li>
                                    <h3>HR Desk</h3>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='employees')}}">
                                        <!--<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3" />
                                            <path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" /></svg>
                                      -->
                                      <i class="icon icon-user"></i> &nbsp;&nbsp; <span class="side-menu__label">Employees</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='widgets')}}">
                                      <!--  <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3" />
                                            <path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" /></svg>
                                        --> <i class="icon icon-people"></i> &nbsp;&nbsp;<span class="side-menu__label">Employee Groups</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='maps')}}">
                                       <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3" />
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
                                            <circle cx="12" cy="9" r="2.5" /></svg>
                                        --> <i class="fe fe-dollar-sign"></i>&nbsp;&nbsp; <span class="side-menu__label">Payroll</span>
                                    </a>
                                </li>
                                <li>
                                    <h3>Admin</h3>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='widgets')}}">
                                       <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M5 5h4v4H5zm10 10h4v4h-4zM5 15h4v4H5zM16.66 4.52l-2.83 2.82 2.83 2.83 2.83-2.83z" opacity=".3" />
                                            <path d="M16.66 1.69L11 7.34 16.66 13l5.66-5.66-5.66-5.65zm-2.83 5.65l2.83-2.83 2.83 2.83-2.83 2.83-2.83-2.83zM3 3v8h8V3H3zm6 6H5V5h4v4zM3 21h8v-8H3v8zm2-6h4v4H5v-4zm8-2v8h8v-8h-8zm6 6h-4v-4h4v4z" /></svg>

                                        --> <i class="fe fe-list"></i>&nbsp;&nbsp;  <span class="side-menu__label">Menu</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='maps')}}">
                                       <!-- <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3" />
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
                                            <circle cx="12" cy="9" r="2.5" /></svg>
                                        --> <i class="fe fe-lock"></i>&nbsp;&nbsp;  <span class="side-menu__label">Action Rights</span>
                                    </a>
                                </li>
                                <li class="slide">
                                    <a class="side-menu__item" href="{{url('/' . $page='maps')}}">
                                    <!--    <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" class="side-menu__icon">
                                            <path d="M0 0h24v24H0V0z" fill="none" />
                                            <path d="M12 4C9.24 4 7 6.24 7 9c0 2.85 2.92 7.21 5 9.88 2.11-2.69 5-7 5-9.88 0-2.76-2.24-5-5-5zm0 7.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z" opacity=".3" />
                                            <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
                                            <circle cx="12" cy="9" r="2.5" /></svg>
                                       --> <i class="fa fa-wrench"></i>&nbsp;&nbsp;  <span class="side-menu__label">Settings</span>
                                    </a>
                                </li>

                            </ul>
                            </aside>
                            <!--/APP-SIDEBAR-->
