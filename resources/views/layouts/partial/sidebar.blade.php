<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
		<img src="{{ asset('backend/dist/img/logo_ingenieriadesistemas.jpeg')}}" alt="Logo"  style="opacity: .8; width:200px; height:70px;">
    </a>
    <div class="sidebar">
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
				<li class="nav-item">
					<a href="{{ url('/home') }}" class="nav-link">
						<i class="nav-icon fas fa-th"></i>
						<p>
							Panel De Control
						</p>
					</a>
				</li>
				
				(auth()->user()->can('paises.index')|| auth()->user()->can('departamentos.index') || auth()->user()->can('ciudads.index') || auth()->user()->can('tipodocumentos.index'))
				<li class="nav-item">
					<a href="#" class="nav-link">
						<i class="nav-icon fas fa-dharmachakra"></i>
						<p>VENTAS<i class="right fas fa-angle-left"></i></p>
					</a>
					<ul class="nav nav-treeview">
						('departamentos.index')
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-map-marker"></i>
									<p>Departamento</p>
								</a>
							</li>
						
						('departamentos.index')
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-map-marker"></i>
									<p>Departamento</p>
								</a>
							</li>
						
						('departamentos.index')
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-map-marker"></i>
									<p>Departamento</p>
								</a>
							</li>
						
						('departamentos.index')
							<li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon fas fa-map-marker"></i>
									<p>Departamento</p>
								</a>
							</li>
						
					</ul>
				</li>
			</ul>
		</nav>
    </div>
</aside>