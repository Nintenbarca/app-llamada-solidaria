<?php
/*
	Template Name: Actividades
*/
?>
<?php get_header(); ?>

<?php
global $post;
$current_page_id = $post->ID;

require_once(get_template_directory()."/clases/registro-actividad.php");
require_once(get_template_directory()."/clases/actividad.php");
?>

<main id="main">
	<section class="actividades-section">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>

					<?php 
					$clase = new Actividad;	
					$posts_per_page = 10;
					// Añade la paginación
					list($actividades, $pagina, $paginas) = $clase->pagination($posts_per_page);

					if (is_user_logged_in() && is_admin_user()) {
						if(isset($_POST['borrar_actividad'])){
							$clase = new Actividad;
							$id = $_POST['id'];
							
							$actividad = $clase->get($id);
							$imagen = $actividad->imagen;
							
							if(isset($imagen)){
								$imagen_id  = attachment_url_to_postid( $imagen );
								wp_delete_attachment($imagen_id, true);
							}
						    $clase->delete($id);
						    // Redirige a la pagina actual
						    wp_redirect(get_permalink($current_page_id));
						}
					} ?>

					<div class="buscadores mb-3">
						<div class="row">
							<div class="col-12 col-lg-4">
								<form id="search_form" class="input-group mb-3 mb-lg-0" method="post">
									<input class="form-control" type="search" name="query_name">
									<input class="btn btn-primary btn-sm" name="buscar_actividad" type="submit" value="Buscar">
								</form>
							</div><!--col-->
							<div class="col-12 col-lg-8">
								<?php
								if(isset($_SESSION['user'])){ ?>
									<form id="search_form" method="post">
										<input class="btn btn-primary" type="submit" name="buscar_registro" value="Buscar actividades registradas">
									</form>
								<?php 
								} ?>
							</div><!--col-->
						</div><!--row-->
					</div><!--buscadores-->

					<?php 
					if(isset($_POST['buscar_actividad'])){
						$query = $_POST['query_name'];
						$actividades = $clase->search($query);
						include(get_template_directory().'/search-form-update.php'); 
					}

					if(!empty($actividades)){
						if (isset($_POST['buscar_registro'])) {
							$clase2 = new RegistroActividad;
							$user_id = $_SESSION['user']->id;
							$registros = $clase2->getByUser($user_id);
							include(get_template_directory().'/search-form-update.php'); 
							
							foreach ($registros as $registro){ 
								$actividad = $clase->get($registro->actividad_id);
								// Añade la lista de actividades
								include(get_template_directory().'/actividades/actividad-content.php');
							} 
						}else{
							foreach ($actividades as $actividad){ 
								// Añade la lista de actividades
								include(get_template_directory().'/actividades/actividad-content.php'); 
							} 
						}
					}
					
					$all_actividades = $clase->getAll();
					if (count($all_actividades) > $posts_per_page) {
						include(get_template_directory().'/pagination.php');
					}

					if(is_user_logged_in() && is_admin_user()){ ?>
						<a class="btn btn-primary" href="<?php the_permalink(48) ?>">Añadir Actividad</a>
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