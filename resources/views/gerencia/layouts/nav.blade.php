<nav class="navbar fixed-top navbar-toggleable-md navbar-inverse bg-inverse">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
	<span class="navbar-toggler-icon"></span>
	</button>
	<h3 class="navbar-brand">Novasys <span class="badge badge-default">2.0</span></h3>
	<div class="collapse navbar-collapse" id="navbarColor01">
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Desarrollo
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
					<a class="dropdown-item" href="#">Producto Terminado</a>
					<a class="dropdown-item" href="#">Familias</a>
					<a class="dropdown-item" href="#">Marcas</a>
					<a class="dropdown-item" href="#">Formatos</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Desarrollo<span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Comercial<span class="sr-only">(current)</span></a>
			</li>

		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="{{ url('') }}"><i class="fa fa-home" aria-hidden="true"></i> Home<span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{ url('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Salir<span class="sr-only">(current)</span></a>
			</li>
		</ul>
	</div>
</nav>
