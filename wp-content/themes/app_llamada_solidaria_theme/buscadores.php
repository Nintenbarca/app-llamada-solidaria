<div class="col-12 col-lg-3">
	<form id="search_form" class="input-group mb-3 mb-lg-0" method="post">
		<input class="form-control" type="search" name="query_name">
		<input class="btn btn-primary btn-sm" name="buscar_usuario" type="submit" value="Buscar">
	</form>
</div><!--col-->
<div class="col-12 col-lg-2">
	<form id="search_form" class="mb-3 mb-lg-0" method="post">
		<select class="form-select" name="query_genero" onchange='this.form.submit()'>
			<option>Buscar por género</option>
			<option value="Masculino">Masculino</option>
			<option value="Femenino">Femenino</option>
		</select>
	</form>
</div><!--col-->
<div class="col-12 col-lg-2">
	<form id="search_form" class="mb-3 mb-lg-0" method="post">
		<select class="form-select" name="query_prioridad" onchange='this.form.submit()'>
			<option>Buscar por prioridad</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
		</select>
	</form>
</div><!--col-->

<?php 
// Obtiene todos los usuarios dependiendo del buscador
// Buscar usuario por nombre
if(isset($_POST['buscar_usuario'])){
	$query = $_POST['query_name'];
	$usuarios = $clase->searchByName($query);
	$familiares = $clase->searchByName($query);
	include(get_template_directory().'/search-form-update.php');

// Buscar usuario por genero
}elseif(isset($_POST['query_genero'])){
	$query = $_POST['query_genero'];
	$usuarios = $clase->searchByGender($query);
	$familiares = $clase->searchByGender($query);	
	include(get_template_directory().'/search-form-update.php');

// Buscar usuario por nivel de prioridad
}elseif(isset($_POST['query_prioridad'])){
	$query = $_POST['query_prioridad'];
	$usuarios = $clase->searchByPriority($query);
	$familiares = $clase->searchByPriority($query);
	include(get_template_directory().'/search-form-update.php');

// Buscar usuario por rol
}elseif(isset($_POST['query_rol'])){
	$query = $_POST['query_rol'];
	$usuarios = $clase->searchByRol($query);
	include(get_template_directory().'/search-form-update.php');

// Buscar familiar por usuario
}elseif(isset($_POST['query_user'])){
	$query = $_POST['query_user'];
	$familiares = $clase->searchByUser($query);
	include(get_template_directory().'/search-form-update.php');
}?>