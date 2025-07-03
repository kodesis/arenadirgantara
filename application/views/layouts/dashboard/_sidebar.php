<aside class="left-sidebar sidebar-dark" id="left-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
        <!-- Aplication Brand -->
        <div class="app-brand">
            <a href="<?= base_url() ?>">
                <img src="<?= base_url() ?>assets/landing-page/img/logo/w_logo.png" class="w-auto" alt="Mono">
                <!-- <span class="brand-name">Arena Dirgantara</span> -->
            </a>
        </div>
        <!-- begin sidebar scrollbar -->
        <div class="sidebar-left" data-simplebar style="height: 100%;">
            <!-- sidebar menu -->
            <ul class="nav sidebar-inner" id="sidebar-menu">
                <li class="<?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                    <a class="sidenav-item-link" href="<?= base_url('dashboard') ?>">
                        <i class="mdi mdi-briefcase-account-outline"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>
                <li class="<?= ($this->uri->segment(1) == 'booking') ? 'active' : '' ?>">
                    <a class="sidenav-item-link" href="<?= base_url('booking') ?>">
                        <i class="mdi mdi-briefcase-account-outline"></i>
                        <span class="nav-text">Booking</span>
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-footer">
            <div class="sidebar-footer-content">
                <ul class="d-flex">
                    <li>
                        <a href="user-account-settings.html" data-toggle="tooltip" title="Profile settings"><i class="mdi mdi-settings"></i></a>
                    </li>
                    <li>
                        <a href="#" data-toggle="tooltip" title="No chat messages"><i class="mdi mdi-chat-processing"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>