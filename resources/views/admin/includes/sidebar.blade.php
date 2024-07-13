<!-- BEGIN SIDEBAR -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            @php
                $loginUserPrivileges = session('loginUserPrivileges');
                $currentUser = str_replace(['[', ']','"'], '', $loginUserPrivileges);
                $userPrivileges = explode(",",$currentUser);
            @endphp
            @if(in_array("*",$userPrivileges) || in_array("DR",$userPrivileges))
                <li class="start {{ (request()->is('admin-dashboard')) ? 'active' : '' }}">
                    <a href="{{route('adminDashboard')}}">
                        <i class="icon-bar-chart"></i>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
            @endif

            @if(in_array("*",$userPrivileges) || in_array("UL",$userPrivileges))
                <li class="{{ (request()->is('user*')) ? 'active' : '' }}">
                    <a href="javascript:;">
                        <i class="icon-anchor"></i>
                        <span class="title">System User</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{ (request()->is('/user-add*')) ? 'active' : '' }}">
                            <a href="{{route('addUser',['id'=>'new'])}}">
                                <i class="icon-speech"></i>
                                <span class="title">Add User</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('/user-list*')) ? 'active' : '' }}">
                            <a href="{{route('userList')}}">
                                <i class="icon-speech"></i>
                                <span class="title">User's List</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

            @if(in_array("*",$userPrivileges) || in_array("RA",$userPrivileges))
                <li class="{{ (request()->is('report*')) ? 'active' : '' }}">
                    <a href="javascript:;">
                        <i class="icon-anchor"></i>
                        <span class="title">Report</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{ (request()->is('/all-pendingKOT*')) ? 'active' : '' }}">
                            <a href="{{route('pendingKOTAll')}}">
                                <i class="icon-speech"></i>
                                <span class="title">Pending KOT</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('/all-kitchenCompleteKOTHistory*')) ? 'active' : '' }}">
                            <a href="{{route('KitchenCompleteKOTHistoryAll')}}">
                                <i class="icon-speech"></i>
                                <span class="title">Kitchen Complete Kot</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('/admin-totalKOT*')) ? 'active' : '' }}">
                            <a href="{{route('adminTotalKOT')}}">
                                <i class="icon-speech"></i>
                                <span class="title">All KOT</span>
                            </a>
                        </li>
                        <li class="{{ (request()->is('/admin-cashPrint*')) ? 'active' : '' }}">
                            <a href="{{route('adminCashPrint')}}">
                                <i class="icon-speech"></i>
                                <span class="title">Cash KOT</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>
<!-- END SIDEBAR -->
