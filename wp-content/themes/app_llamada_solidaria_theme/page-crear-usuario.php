<?php
/*
	Template Name: Crear Usuario
*/
?>
<?php get_header(); ?>

<?php
global $post;
$current_page_id = $post->ID;

require_once(get_template_directory()."/clases/rol.php");
require_once(get_template_directory()."/clases/usuario.php");
?>

<main id="main">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>
					<?php 
					//session_start();
					if (!empty($_SESSION['errores'])) {
						echo "<ul>";
						while (!empty($_SESSION['errores'])) {
							echo "<li>". array_pop($_SESSION['errores']) ."</li>";
						}
						echo "</ul>";
					}	

					if (isset($_SESSION['user']) && $_SESSION['user']->rol_id == 1){
						wp_redirect(get_home_url());
					}
					
					if(isset($_POST['crear_usuario'])){
						if (!isset($_SESSION['errores'])) {
							$_SESSION['errores'] = array();
						}

						$nombre = $_POST['nombre'];
						$apellidos = $_POST['apellidos'];
						$email = $_POST['email'];
						$pass = $_POST['pass'];
						$pass2 = $_POST['pass2'];
						$genero = $_POST['genero'];
						$dni = $_POST['dni'];
						$direccion = $_POST['direccion'];
						$telefono = $_POST['telefono'];
						$prioridad = $_POST['prioridad'];
						$profesion = $_POST['profesion'];
						$rol_id = $_POST['rol_id'];

						$clase = new Usuario;
						$usuario_email = $clase->getByEmail($email);
						$usuario_dni = $clase->getByDNI($dni);
						$usuario_phone = $clase->getByPhone($telefono);

						if (isset($usuario_email)) {
							array_push($_SESSION["errores"], "Ya existe un usuario con este email");
						}

						if (isset($usuario_dni)) {
							array_push($_SESSION["errores"], "Ya existe un usuario con este DNI");
						}

						if (isset($usuario_phone)) {
							array_push($_SESSION["errores"], "Ya existe un usuario con este teléfono");
						}

						if ($pass != $pass2) {
							array_push($_SESSION['errores'], 'Las contraseñas deben ser iguales');
						}

						if (empty($_SESSION['errores'])){
							if(is_user_logged_in() && is_admin_user()){
								$params = array(
									'nombre' => $nombre, 
									'apellidos' => $apellidos,
									'email' => $email,
									'pass' => md5($pass),
									'genero' => $genero,
									'dni' => $dni,
									'direccion' => $direccion,
									'telefono' => $telefono,
									'prioridad' => $prioridad,
									'profesion' => $profesion,
									'rol_id' => $rol_id
								);
							}else{
								$params = array(
									'nombre' => $nombre, 
									'apellidos' => $apellidos,
									'email' => $email,
									'pass' => md5($pass),
									'genero' => $genero,
									'dni' => $dni,
									'direccion' => $direccion,
									'telefono' => $telefono
								);
							}
							$clase->create($params);
						    wp_redirect(get_permalink(19));
						}else{
							wp_redirect(get_permalink($current_page_id));
						}							
					}?>

					<form method="post">
						<p><label for="nombre">Nombre: </label>
						<input class="form-control" type="text" id="nombre" name="nombre" maxlength="50" required></p>

						<p><label for="apellidos">Apellidos: </label>
						<input class="form-control" type="text" id="apellidos" name="apellidos" maxlength="50" required></p>

						<p><label for="email">Email: </label>
						<input class="form-control" type="email" id="email" name="email" maxlength="50" required></p>

						<p><label for="genero">Genero: </label>
						<select class="form-select" id="genero" name="genero" required>
							<option value="Masculino">Masculino</option>
							<option value="Femenino">Femenino</option>
						</select></p>

						<p><label for="dni">DNI: </label>
						<input class="form-control" type="text" id="dni" name="dni" maxlength="10" required></p>

						<p><label for="direccion">Dirección: </label>
						<input class="form-control" type="text" id="direccion" name="direccion" maxlength="50" required></p>

						<p><label for="telefono">Teléfono: </label>
						<input class="form-control" type="number" id="telefono" name="telefono" maxlength="9" required></p>

						<p><label for="pass">Contraseña: </label>
						<input class="form-control" type="password" id="pass" name="pass" maxlength="50" required></p>

						<p><label for="pass2">Repetir Contraseña: </label>
						<input class="form-control" type="password" id="pass2" name="pass2" maxlength="50" required></p>

						<?php if (is_user_logged_in() && is_admin_user()){ ?>
							<p><label for="prioridad">Nivel de prioridad: </label>
							<select class="form-select" id="prioridad" name="prioridad">
								<option>Elegir nivel</option>
								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
							</select></p>

							<p><label for="profesion">Profesión: </label>
							<input class="form-control" type="text" id="profesion" name="profesion" maxlength="50"></p>

							<p><label for="rol_id">Rol: </label>
							<select class="form-select" id="rol_id" name="rol_id">
								<?php
								$clase2 = new Rol;
								$roles = $clase2->getAll();

								foreach ($roles as $rol) {
									echo '<option value ="'.$rol->id.'">'. $rol->nombre .'</option>';
								}	
							
								?>
							</select></p>
						<?php 
						} ?>						

						<input type="submit" name="crear_usuario" class="btn btn-primary" value="Crear">
					</form>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>