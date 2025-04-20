    <!-- Left Sidebar Start -->
    <div class="app-sidebar-menu">
        <div class="h-100" data-simplebar>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <div class="logo-box">
                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="" height="24">
                        </span>
                    </a>
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/logo-sm.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/logo-dark.png') }}" alt="" height="24">
                        </span>
                    </a>
                </div>

                <ul id="side-menu">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('admin.home') }}">
                            <i class="fi fi-rs-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <!-- Menu untuk User & Admin -->
                    @can('category_read')
                        <li>
                            <a
                                href="{{ auth()->user()->hasRole('Admin') ? route('admin.kategori.index') : route('kategori.index') }}">
                                <i class="fi fi-rs-category"></i>
                                <span> Kategori </span>
                            </a>
                        </li>
                    @endcan

                    @can('event_read')
                        <li>
                            <a
                                href="{{ auth()->user()->hasRole('Admin') ? route('admin.events.index') : route('events.index') }}">
                                <i class="fi fi-rs-calendar-arrow-down"></i>
                                <span> Event </span>
                            </a>
                        </li>
                    @endcan

                    @can('ticket_read')
                        <li>
                            <a
                                href="{{ auth()->user()->hasRole('Admin') ? route('admin.tiket.index') : route('tiket.index') }}">
                                <i class="fi fi-rs-ticket"></i>
                                <span> Tiket </span>
                            </a>
                        </li>
                    @endcan

                    <!-- Menu Khusus Admin -->
                    @if (auth()->user()->hasRole('Admin'))
                        <li>
                            <a href="{{ route('admin.pengajuan.index') }}">
                                <i class="fi fi-rs-memo-circle-check"></i>
                                <span> Pengajuan </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.pembayaran.index') }}">
                                <i class="fi fi-rs-memo-circle-check"></i>
                                <span> Pembayaran </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.penyelenggara.index') }}">
                                <i class="fi fi-rs-member-list"></i>
                                <span> Akun </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pesan.index') }}">
                                <i class="fi fi-rs-member-list"></i>
                                <span> Pesan </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Left Sidebar End -->
