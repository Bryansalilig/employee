<ul class="side-menu metismenu">
    <li class="active">
        <a href="{{ route('home') }}">
            <i class="sidebar-item-icon fa fa-th-large"></i>
            <span class="nav-label">Home</span>
        </a>
    </li>
    <li>
        <a href="javascript:;">
            <i class="sidebar-item-icon fa fa-shield"></i>
            <span class="nav-label">Company Policy</span>

            <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="colors.html">
                    Attendance
                </a>
            </li>
            <li>
                <a href="typography.html">Company Directives</a>
            </li>
            <li>
                <a href="panels.html">Dress Code</a>
            </li>
            <li>
                <a href="buttons.html">eCodes</a>
            </li>
            <li>
                <a href="tabs.html">Waste Segregation</a>
            </li>
            <li>
                <a href="alerts_tooltips.html">Loitering After Office Hrs</a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:;" class="menu-link">
            <i class="sidebar-item-icon fa fa-newspaper-o"></i>
            <span class="nav-label">Form</span><i class="fa fa-angle-left arrow"></i></a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="<?= url('evaluation')?>" class="sub-menu-link" data-id="i">Performance Evaluation</a>
            </li>
            <li>
                <a href="<?= url('development')?>" class="sub-menu-link" data-id="j">Yearly Development</a>
            </li>
        </ul>
    </li>
    <li class="menu-item">
        <a href="javascript:;" class="menu-link">
            <i class="sidebar-item-icon fa fa-clock-o"></i>
            <span class="nav-label">Timekeeping</span><i class="fa fa-angle-left arrow"></i></a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="<?= url('overtime')?>" class="sub-menu-link" data-id="l">Overtime</a>
            </li>
            <li>
                <a href="<?= url('undertime')?>" class="sub-menu-link" data-id="m">Undertime</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="icons.html"><i class="sidebar-item-icon fa fa-user-plus"></i>
            <span class="nav-label">Job Referral</span>
        </a>
    </li>
    <li>
        <a href="icons.html"><i class="sidebar-item-icon fa fa-calendar"></i>
            <span class="nav-label">Events</span>
        </a>
    </li>
    <li>
        <a href="icons.html"><i class="sidebar-item-icon fa fa-sitemap"></i>
            <span class="nav-label">Employee Hierarchy</span>
        </a>
    </li>
    <li>
    <a href="{{ route('login') }}"><i class="sidebar-item-icon fa fa-sign-in"></i> Login</a>


        </a>
    </li>
</ul>