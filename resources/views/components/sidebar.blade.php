<div class="sidebar" style="font-size: 0.9rem">
    <nav class="mt-4">
        <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <x-nav-link class="nav-link" :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                    <i class="nav-icon fas fa-th-large mr-2"></i><p>{{ __('Dashboard') }}</p>
                </x-nav-link>
            </li>

            <li class="nav-item">
                <x-nav-link class="nav-link" href="#">
                    <i class="nav-icon fa fa-clipboard-list mr-2"></i><p>Pengajuan</p>
                </x-nav-link>
            </li>

            <li class="nav-item">
                <x-nav-link class="nav-link" href="#">
                    <i class="nav-icon fa fa-clipboard-check mr-2"></i><p>Persetujuan</p>
                </x-nav-link>
            </li>
        </ul>
    </nav>
</div>