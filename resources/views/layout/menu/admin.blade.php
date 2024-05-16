<ul class="side-menu metismenu">
<li class="menu-item">
        <a href="javascript:;" class="menu-link">
            <i class="sidebar-item-icon fa fa-th-large"></i>
            <span class="nav-label">Dashboard</span>
            <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="{{ route('dashboard') }}" class="sub-menu-link" data-id="a">Administrator</a>
            </li>
            <li>
                <a href="{{ route('home') }}" class="sub-menu-link" data-id="b">Regular</a>
            </li>
        </ul>
    </li>
    <li>
        <a href="{{ url('company-policy') }}"><i class="sidebar-item-icon fa fa-shield"></i>
            <span class="nav-label">Company Policy</span>
        </a>
    </li>
<!--     <li class="menu-item">
        <a href="javascript:;" class="menu-link">
            <i class="sidebar-item-icon fa fa-shield"></i>
            <span class="nav-label">Company Policy</span>
            <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="colors.html" class="sub-menu-link" data-id="c">Attendance</a>
            </li>
            <li>
                <a href="typography.html" class="sub-menu-link" data-id="d">Company Directives</a>
            </li>
            <li>
                <a href="panels.html" class="sub-menu-link" data-id="e">Dress Code</a>
            </li>
            <li>
                <a href="buttons.html" class="sub-menu-link" data-id="f">eCodes</a>
            </li>
        </ul>
    </li> -->
    <li class="menu-item">
        <a href="javascript:;" class="menu-link">
            <i class="sidebar-item-icon fa fa-user"></i>
            <span class="nav-label">Employees</span>
            <i class="fa fa-angle-left arrow"></i>
        </a>
        <ul class="nav-2-level collapse">
            <li>
                <a href="{{ url('employees') }}" class="sub-menu-link" data-id="g">Active Employees</a>
            </li>
            <li>
                <a href="<?= url('employees/separated') ?>" class="sub-menu-link" data-id="h">Separated Employees</a>
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
    <li<?= @($menu == 'board') ? ' class="active"' : '' ?>>
    <a href="javascript:;">
      <i class="sidebar-item-icon fa fa-newspaper-o"></i>
      <span class="nav-label">Board</span>
      <i class="fa fa-angle-left arrow"></i>
    </a>
    <ul class="nav-2-level collapse">
      <li><a<?= @($submenu == 'activities') ? ' class="active"' : '' ?> href="<?= route('activities') ?>">Activities</a></li>
      <li><a<?= @($submenu == 'events') ? ' class="active"' : '' ?> href="<?= route('events') ?>">Events</a></li>
      <li><a<?= @($submenu == 'banner') ? ' class="active"' : '' ?> href="<?= route('banner') ?>">Banner</a></li>
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
    <li class="menu-item">
        <a href="<?= url('leave') ?>" class="sub-menu-link" data-id="n">
            <i class="sidebar-item-icon fa fa-calendar-o"></i>
            <span class="nav-label">Leaves</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= url('dainfraction')?>" class="sub-menu-link" data-id="o"><i class="sidebar-item-icon fa fa-warning"></i>
            <span class="nav-label">DA Infractions</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= url('coaching-session') ?>" class="sub-menu-link" data-id="p"><i class="sidebar-item-icon fa fa-cogs"></i>
            <span class="nav-label">Linking Sessions</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= url('department')?>" class="sub-menu-link" data-id="q"><i class="sidebar-item-icon fa fa-users"></i>
            <span class="nav-label">Departments</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= url('referral')?>" class="sub-menu-link" data-id="r"><i class="sidebar-item-icon fa fa-user-plus"></i>
            <span class="nav-label">Referrals</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= url('setting')?>" class="sub-menu-link" data-id="s"><i class="sidebar-item-icon fa fa-cog"></i>
            <span class="nav-label">Setting</span>
        </a>
    </li>
    <li class="menu-item">
        <a href="<?= asset('public/img/company-hierarchy.jpeg') ?>" class="sub-menu-link" data-id="t"><i class="sidebar-item-icon fa fa-sitemap"></i>
            <span class="nav-label">Employee Hierarchy</span>
        </a>
    </li>
    <li>
        <a href="<?= url('logout') ?>"><i class="sidebar-item-icon fa fa-power-off"></i>
            <span class="nav-label">Logout</span>
        </a>
    </li>
    <li class="heading">PAGES</li>
</ul>