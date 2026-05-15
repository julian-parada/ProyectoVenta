
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('backend/dist/img/logo_ingenieriadesistemas.jpeg')}}" alt="Logo"
            style="opacity: .8; width:200px; height:70px;">
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ url('/home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Panel De Control</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->is('clientes*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Clientes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('productos.index') }}" class="nav-link {{ request()->is('productos*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Productos</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('empleados.index') }}" class="nav-link {{ request()->is('empleados*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-tie"></i>
                        <p>Empleados</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('facturas.index') }}" class="nav-link {{ request()->is('facturas*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file-invoice-dollar"></i>
                        <p>Facturas</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('metodopagos.index') }}" class="nav-link {{ request()->is('metodopagos*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>Métodos de Pago</p>
                    </a>
                </li>

                {{-- Separador de cuenta --}}
                <li class="nav-header">MI CUENTA</li>

                <li class="nav-item">
                    <a href="{{ route('profile.edit') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>Mi Perfil</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('profile.change-password') }}" class="nav-link {{ request()->is('profile/change-password') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Cambiar Contraseña</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
