<?php
/*
	Template Name: Editar Usuario
*/
?>
<?php get_header(); ?>

<?php
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

					$clase = new Usuario;
					$id = $_GET['id'];
					$usuario = $clase->get($id);

					if ((is_user_logged_in() && is_admin_user()) || 
						(isset($_SESSION['user']) && $_SESSION['user']->id == $usuario->id)){

						if(isset($_POST['editar_usuario'])){
							$nombre = $_POST['nombre'];
							$apellidos = $_POST['apellidos'];
							$genero = $_POST['genero'];
							$direccion = $_POST['direccion'];
							$prioridad = $_POST['prioridad'];
							$profesion = $_POST['profesion'];
							$rol_id = $_POST['rol_id'];

							if(is_user_logged_in() && is_admin_user()){
								$params = array(
									'nombre' => $nombre, 
									'apellidos' => $apellidos,
									'genero' => $genero,
									'direccion' => $direccion,
									'prioridad' => $prioridad,
									'profesion' => $profesion,
									'rol_id' => $rol_id
								);
							}else{
								$params = array(
									'nombre' => $nombre, 
									'apellidos' => $apellidos,
									'genero' => $genero,
									'direccion' => $direccion
								);
							}

							$clase->update($params, $id);
						    wp_redirect(get_permalink(19));
						}							
					}else{
						wp_redirect(get_home_url());
					}?>

					<form method="post">
						<input type="hidden" name="id" value="<?php echo $usuario->id;?>">

						<p><label for="nombre">Nombre: </label>
						<input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $usuario->nombre;?>" maxlength="50" required></p>

						<p><label for="apellidos">Apellidos: </label>
						<input class="form-control" type="text" id="apellidos" name="apellidos" value="<?php echo $usuario->apellidos;?>" maxlength="50" required></p>

						<p><label for="genero">Genero: </label>
						<select class="form-select" id="genero" name="genero" required>
							<option value="Masculino"
								<?php
								if($usuario->genero == 'Masculino'){ ?>
									selected
								<?php
								}?>
							>
								Masculino
							</option>
							<option value="Femenino"
								<?php
								if($usuario->genero == 'Femenino'){ ?>
									selected
								<?php
								}?>
							>
								Femenino
							</option>
						</select></p>

						<p><label for="direccion">Dirección: </label>
						<input class="form-control" type="text" id="direccion" name="direccion" value="<?php echo $usuario->direccion;?>" maxlength="50" required></p>

						<?php if (is_user_logged_in() && is_admin_user()){ ?>
							<p><label for="prioridad">Nivel de prioridad: </label>
							<select class="form-select" id="prioridad" name="prioridad">
								<option>Elegir nivel</option>
								<option value="1"
									<?php
									if($usuario->prioridad == 1){ ?>
										selected
									<?php
									}?>
								>
									1
								</option>
								<option value="2"
									<?php
									if($usuario->prioridad == 2){ ?>
										selected
									<?php
									}?>
								>
									2
								</option>
								<option value="3"
									<?php
									if($usuario->prioridad == 3){ ?>
										selected
									<?php
									}?>
								>
									3
								</option>
							</select></p>

							<p><label for="profesion">Profesión: </label>
							<input class="form-control" type="text" id="profesion" name="profesion" value="<?php echo $usuario->profesion;?>" maxlength="50"></p>

							<p><label for="rol_id">Rol: </label>
							<select class="form-select" id="rol_id" name="rol_id">
								<?php
								$clase2 = new Rol;
								$roles = $clase2->getAll();

								foreach ($roles as $rol) { ?>
									<option value="<?php echo $rol->id ?>"
										<?php
										if($rol->id == $usuario->rol_id){ ?>
											selected
										<?php
										}?>
									>
										<?php echo $rol->nombre ?>
									</option>
								<?php 
								}?>
							</select></p>
						<?php 
						} ?>						

						<input type="submit" name="editar_usuario" class="btn btn-primary" value="Editar">
					</form>
					<!--<a class="btn btn-primary mt-3" href="<?php the_permalink(19) ?>">Volver al listado</a>-->
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>