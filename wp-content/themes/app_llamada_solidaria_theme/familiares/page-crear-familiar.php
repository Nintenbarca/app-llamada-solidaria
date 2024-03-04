<?php
/*
	Template Name: Crear Familiar
*/
?>
<?php get_header(); ?>

<?php
global $post;
$current_page_id = $post->ID;

require_once(get_template_directory()."/clases/usuario.php");
require_once(get_template_directory()."/clases/familiar.php");
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

					if((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){
						if(isset($_POST['crear_familiar'])){
							if (!isset($_SESSION['errores'])) {
								$_SESSION['errores'] = array();
							}

							$nombre = $_POST['nombre'];
							$apellidos = $_POST['apellidos'];
							$email = $_POST['email'];
							$genero = $_POST['genero'];
							$dni = $_POST['dni'];
							$parentesco = $_POST['parentesco'];
							$direccion = $_POST['direccion'];
							$telefono = $_POST['telefono'];
							$prioridad = $_POST['prioridad'];
							if(is_user_logged_in() && is_admin_user()){
								$user_id = $_POST['user_id'];
							}else{
								$user_id = $_SESSION['user']->id;
							}

							$clase = new Familiar;
							$familiar_email = $clase->getByEmail($email);
							$familiar_dni = $clase->getByDNI($dni);
							$familiar_phone = $clase->getByPhone($telefono);

							if (isset($familiar_email)) {
								array_push($_SESSION["errores"], "Ya existe un familiar con este email");
							}

							if (isset($familiar_dni)) {
								array_push($_SESSION["errores"], "Ya existe un familiar con este DNI");
							}

							if (isset($familiar_phone)) {
								array_push($_SESSION["errores"], "Ya existe un familiar con este teléfono");
							}

							if (empty($_SESSION['errores'])){
								$params = array(
									'nombre' => $nombre, 
									'apellidos' => $apellidos,
									'email' => $email,
									'genero' => $genero,
									'dni' => $dni,
									'parentesco' => $parentesco,
									'direccion' => $direccion,
									'telefono' => $telefono,
									'prioridad' => $prioridad,
									'user_id' => $user_id
								);
								$clase->create($params);
							    wp_redirect(get_permalink(28));
							}else{
								wp_redirect(get_permalink($current_page_id));
							}							
						}
					}else{
						wp_redirect(get_home_url());
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

						<p><label for="parentesco">Parentesco: </label>
						<input class="form-control" type="text" id="parentesco" name="parentesco" maxlength="50" required></p>

						<p><label for="direccion">Dirección: </label>
						<input class="form-control" type="text" id="direccion" name="direccion" maxlength="50" required></p>

						<p><label for="telefono">Teléfono: </label>
						<input class="form-control" type="number" id="telefono" name="telefono" maxlength="9" required></p>
						
						<p><label for="prioridad">Nivel de prioridad: </label>
						<select class="form-select" id="prioridad" name="prioridad">
							<option>Elegir nivel</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
						</select></p>		

						<?php
						if (is_user_logged_in() && is_admin_user()) { 
							$clase2 = new Usuario;
							$usuarios = $clase2->getAll();
						?>
							<p><label for="user_id">Usuario del que es familiar: </label>
							<select class="form-select" id="user_id" name="user_id" required>
								<?php foreach($usuarios as $usuario){ ?>
									<option value="<?php echo $usuario->id;?>">
										<?php echo $usuario->nombre." ".$usuario->apellidos;?>
									</option>
								<?php 
								} ?>
							</select></p>
						<?php 
						} ?>	

						<input type="submit" name="crear_familiar" class="btn btn-primary" value="Añadir">
					</form>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>