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
    <a href="{{ url('/jenis_gabah') }}" class="btn btn-link {{ request()->is('jenis_gabah') ? 'active' : '' }}"
        title="Lihat dan kelola jenis gabah">Jenis Gabah</a>
    <a href="{{ url('/data_device') }}" class="btn btn-link {{ request()->is('data_device') ? 'active' : '' }}"
        title="Lihat data sensor">Perangkat IoT</a>
    <a href="{{ url('/roles') }}" class="btn btn-link {{ request()->is('roles') ? 'active' : '' }}"
        title="Kelola pengaturan role pengguna">Pengelolaan Pengguna</a>
</div>
