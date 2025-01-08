<div class="sidebar" data-background-color="custom">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="custom">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/kaiadmin/tsearch_logo.png') }}" alt="navbar brand" class="navbar-brand"
                    height="60" />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" aria-expanded="false">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.guestAccount', 'admin.faculty') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#base_user">
                        <i class="fa-solid fa-users"></i>
                        <p>Users</p>
                        <span class="caret"></span>
                    </a>

                    <div class="collapse" id="base_user">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/guestAccount') ? 'active' : '' }}">
                                <a href="{{ route('admin.guestAccount') }}">
                                    <span class="sub-item">Student</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/faculty') ? 'active' : '' }}">
                                <a href="{{ route('admin.faculty') }}">
                                    <span class="sub-item">Faculty</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ Request::routeIs('admin.file.published', 'admin.imrad', 'admin.imrad') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#base_file">
                        <i class="fa-solid fa-book"></i>
                        <p>File Upload</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base_file">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/file/published') ? 'active' : '' }}">
                                <a href="{{ route('admin.file.published') }}">
                                    <span class="sub-item">Published</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/file/archived') ? 'active' : '' }}">
                                <a href="{{ route('admin.file.archived') }}">
                                    <span class="sub-item">Archived</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/file/draft') ? 'active' : '' }}">
                                <a href="{{ route('admin.file.draft') }}">
                                    <span class="sub-item">Draft</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li
                    class="nav-item {{ Request::routeIs('report.generation.file.upload', 'report.generation.file.sdg', 'report.generation.file.rating') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#base">
                        <i class="fa-solid fa-chart-bar"></i>
                        <p>Report</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/file-upload') ? 'active' : '' }}">
                                <a href="{{ route('report.generation.file.upload') }}">
                                    <span class="sub-item">File Upload</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/file-sdg') ? 'active' : '' }}">
                                <a href="{{ route('report.generation.file.sdg') }}">
                                    <span class="sub-item">File SDG</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/file-rating') ? 'active' : '' }}">
                                <a href="{{ route('report.generation.file.rating') }}">
                                    <span class="sub-item">File Rating</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.log') ? 'active' : '' }}">
                    <a href="{{ route('admin.log') }}">
                        <i class="fa-solid fa-history"></i>
                        <p>Log History</p>
                    </a>
                </li>

                <li class="nav-item {{ Request::routeIs('admin.trash-user', 'admin.trash-file') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#base_trash">
                        <i class="fa-solid fa-trash"></i>
                        <p>Trash Bin</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="base_trash">
                        <ul class="nav nav-collapse">
                            <li class="{{ Request::is('admin/trash-user') ? 'active' : '' }}">
                                <a href="{{ route('admin.trash-user') }}">
                                    <span class="sub-item">Trash User</span>
                                </a>
                            </li>
                            <li class="{{ Request::is('admin/trash-file') ? 'active' : '' }}">
                                <a href="{{ route('admin.trash-file') }}">
                                    <span class="sub-item">Trash File</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
