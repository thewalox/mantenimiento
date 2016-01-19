<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title><?php echo $titulo; ?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-fileinput.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jasny-bootstrap.min.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sub-menus.css" media="screen">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/number-format.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

	<style>
		.ui-autocomplete-loading {
	    background: white url("<?php echo base_url(); ?>assets/img/ajax-loader-small.gif") right center no-repeat;
	  	}
  	</style>

</head>
<body>
	
	<header>
		<nav class="navbar navbar-inverse navbar-static-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#menu">
						<span class="sr-only">Desplegar / Ocultar Menu</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a href="<?php echo base_url(); ?>home" class="navbar-brand">Mantenimiento</a>
				</div>
				<div class="collapse navbar-collapse" id="menu">
					<ul class="nav navbar-nav">
						<li class="active"><a href="<?php echo base_url(); ?>home">Inicio</a></li>

						<?php
							if($this->session->userdata('sess_perfil') == 1){
						?>

						<li class="menu-item dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Administrador <span class="caret"></span></a>
							<ul class="dropdown-menu">
					           	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Usuarios</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>usuarios/form_crear">Crear Usuario</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>usuarios/form_buscar">Editar Usuarios</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Departamentos</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>departamentos/form_crear">Crear Departamento</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>departamentos/form_buscar">Editar Departamentos</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Empleados</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>empleados/form_crear">Crear Empleado</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>empleados/form_buscar">Editar Empleados</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Secciones</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>secciones/form_crear">Crear Seccion</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>secciones/form_buscar">Editar Secciones</a></li>
		                            </ul>
	                        	</li>
	                        	<li role="separator" class="divider"></li>
	                        	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Maquinas</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>maquinas/form_crear">Crear Maquina</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>maquinas/form_buscar">Editar Maquinas</a></li>
		                            </ul>
	                        	</li>
				          	</ul>				
						</li>
						<li class="menu-item dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Mantenimiento <span class="caret"></span></a>
							<ul class="dropdown-menu">
					           	<li class="menu-item dropdown dropdown-submenu">
		                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Solicitudes</a>
		                            <ul class="dropdown-menu">
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>solicitudes/form_crear">Crear Solicitud</a></li>
		                                <li role="separator" class="divider"></li>
		                                <li class="menu-item "><a href="<?php echo base_url(); ?>solicitudes/form_buscar">Gestion de Solicitudes</a></li>
		                            </ul>
	                        	</li>
				          	</ul>				
						</li>

						<?php
							}
						?>
						
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $this->session->userdata('sess_name_user'); ?><span class="caret"></span></a>
							<ul class="dropdown-menu">
					            <li><a href="<?php echo base_url(); ?>login/logout"><strong>Cerrar Sesion </strong><span class="glyphicon glyphicon-off"></span></a></li>
				          	</ul>				
						</li>
      				</ul>
				</div>
			</div>
		</nav>
	</header>