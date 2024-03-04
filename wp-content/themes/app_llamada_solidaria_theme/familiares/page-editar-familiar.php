<?php
/*
	Template Name: Editar Familiar
*/
?>
<?php get_header(); ?>

<?php
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

					$clase = new Familiar;
					$id = $_GET['id'];
					$familiar = $clase->get($id);

					if ((is_user_logged_in() && is_admin_user()) || 
						(isset($_SESSION['user']) && $_SESSION['user']->id == $familiar->user_id)){

						if(isset($_POST['editar_familiar'])){
							$nombre = $_POST['nombre'];
							$apellidos = $_POST['apellidos'];
							$genero = $_POST['genero'];
							$parentesco = $_POST['parentesco'];
							$direccion = $_POST['direccion'];
							$prioridad = $_POST['prioridad'];
							$params = array(
								'nombre' => $nombre, 
								'apellidos' => $apellidos,
								'genero' => $genero,
								'parentesco' => $parentesco,
								'direccion' => $direccion,
								'prioridad' => $prioridad
							);

							$clase->update($params, $id);
						    wp_redirect(get_permalink(28));
						}							
					}else{
						wp_redirect(get_home_url());
					}?>

					<form method="post">
						<input type="hidden" name="id" value="<?php echo $familiar->id;?>">

						<p><label for="nombre">Nombre: </label>
						<input class="form-control" type="text" id="nombre" name="nombre" value="<?php echo $familiar->nombre;?>" maxlength="50" required></p>

						<p><label for="apellidos">Apellidos: </label>
						<input class="form-control" type="text" id="apellidos" name="apellidos" value="<?php echo $familiar->apellidos;?>" maxlength="50" required></p>

						<p><label for="genero">Genero: </label>
						<select class="form-select" id="genero" name="genero" required>
							<option value="Masculino"
								<?php
								if($familiar->genero == 'Masculino'){ ?>
									selected
								<?php
								}?>
							>
								Masculino
							</option>
							<option value="Femenino"
								<?php
								if($familiar->genero == 'Femenino'){ ?>
									selected
								<?php
								}?>
							>
								Femenino
							</option>
						</select></p>

						<p><label for="parentesco">Parentesco: </label>
						<input class="form-control" type="text" id="parentesco" name="parentesco" value="<?php echo $familiar->parentesco;?>" maxlength="50" required></p>

						<p><label for="direccion">Dirección: </label>
						<input class="form-control" type="text" id="direccion" name="direccion" value="<?php echo $familiar->direccion;?>" maxlength="50" required></p>

						<?php /*if (is_user_logged_in() && is_admin_user()){ */?>
							<p><label for="prioridad">Nivel de prioridad: </label>
							<select class="form-select" id="prioridad" name="prioridad">
								<option>Elegir nivel</option>
								<option value="1"
									<?php
									if($familiar->prioridad == 1){ ?>
										selected
									<?php
									}?>
								>
									1
								</option>
								<option value="2"
									<?php
									if($familiar->prioridad == 2){ ?>
										selected
									<?php
									}?>
								>
									2
								</option>
								<option value="3"
									<?php
									if($familiar->prioridad == 3){ ?>
										selected
									<?php
									}?>
								>
									3
								</option>
							</select></p>
						<?php 
						/*} */?>
						<input type="submit" name="editar_familiar" class="btn btn-primary" value="Editar">
					</form>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>