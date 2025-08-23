<style>
    .btn-link {
        text-decoration: none;
        color: #000;
        font-weight: 500;
        padding: 10px 15px;
        display: inline-flex;
        margin-right: 10px;
        position: relative;
        justify-content: center;
    }

    .btn-link.active {
        color: #1E3B8A;
        font-weight: bold;
    }

    .btn-link.active::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        right: 0;
        height: 2px;
        background-color: #1E3B8A;
    }
</style>

<h4 class="fw-semibold mb-3" style="margin-top: 10px;">Data Master</h4>

<div class="btn-group" role="group" aria-label="Data Master buttons">
    @if (in_array('view data jenis gabah', session('user_permissions', [])))
        <a href="{{ url('/jenis_gabah') }}" class="btn btn-link {{ request()->is('jenis_gabah') ? 'active' : '' }}"
            title="Lihat dan kelola jenis gabah">Jenis Gabah</a>
    @endif
    @if (in_array('view data perangkat', session('user_permissions', [])))
        <a href="{{ url('/data_device') }}" class="btn btn-link {{ request()->is('data_device') ? 'active' : '' }}"
            title="Lihat data perangkat">Perangkat IoT</a>
    @endif
    @if (in_array('view data warehouses', session('user_permissions', [])))
        <a href="{{ url('/warehouse') }}" class="btn btn-link {{ request()->is('warehouse') ? 'active' : '' }}"
            title="Lihat data gudang">Kelola Gudang</a>
    @endif
    @if (in_array('view data bed dryer', session('user_permissions', [])))
        <a href="{{ url('/bed_dryer') }}" class="btn btn-link {{ request()->is('bed_dryer') ? 'active' : '' }}"
            title="Lihat data gudang">Kelola Bed Dryer</a>
    @endif
    @if (in_array('view role', session('user_permissions', [])))
        <a href="{{ url('/role_manage') }}" class="btn btn-link {{ request()->is('role_manage') ? 'active' : '' }}"
            title="Kelola data pengguna">Pengelolaan Pengguna</a>
    @endif
</div>
