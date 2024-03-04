<?php
/*
	Template Name: Ver Actividad
*/
?>
<?php get_header(); ?>

<?php
require_once(get_template_directory()."/clases/actividad.php");
require_once(get_template_directory()."/clases/registro-actividad.php");
?>

<main id="main">
	<section class="actividad-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<?php 
					$clase = new Actividad;
					$id = $_GET['id'];
					$actividad = $clase->get($id);
					$fecha = strtotime($actividad->fecha);
					$imagen = $actividad->imagen;

					if(isset($_SESSION['user'])){
						$clase2 = new RegistroActividad;
						$user_id = $_SESSION['user']->id;	
						$genre_url = add_query_arg('id', $actividad->id, get_permalink(70));

						if(isset($_POST['apuntar_actividad'])){
							$params = array(
								'actividad_id' => $actividad->id, 
								'user_id' => $user_id
							);
							$clase2->create($params);
						    wp_redirect($genre_url);

						}elseif(isset($_POST['desapuntar_actividad'])){
							$id = $_POST['id'];
							$clase2->delete($id);
						    wp_redirect($genre_url);
						}
					}?>

					<h1><?php echo $actividad->titulo; ?></h1>
					<?php 
					if (!empty($imagen)) { ?>
						<div class="thumb-container mb-3" style="background-image: url(<?php echo $imagen; ?>);"></div>
					<?php 
					}else{ ?>
						<div class="thumb-container mb-3" style="background-image: url('http://localhost/app_llamada_solidaria/wp-content/uploads/2024/02/Logo-AFA-Levante.png');"></div>
					<?php 
					}?>
					<p><b><?php echo date('d-m-Y', $fecha); ?></b></p>
					<?php echo $actividad->contenido; ?>

					<?php 
					if (isset($_SESSION['user'])) { 
						$clase2 = new RegistroActividad;
						$user_id = $_SESSION['user']->id;
						$registro = $clase2->getRegistro($actividad->id, $user_id);	
					?>

						<div class="mt-4">
							<?php 
							if(isset($registro)){ ?>
								<form method="post">
									<input type="hidden" name="id" value="<?php echo $registro->id;?>">
									<input class="btn btn-danger" type="submit" name="desapuntar_actividad" value="Desapuntarse de la actividad">
								</form>
							<?php 
							}else{ ?>
								<form method="post">
									<input class="btn btn-primary" type="submit" name="apuntar_actividad" value="Apuntarse a la actividad">
								</form>
							<?php 
							} ?>
						</div>
					<?php 
					} ?>					
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>