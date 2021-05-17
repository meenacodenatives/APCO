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
    <div id="load-sidebar"></div>

    <ul class="side-menu" id="showChildMenu">
    </ul>
</aside>
<!--/APP-SIDEBAR-->