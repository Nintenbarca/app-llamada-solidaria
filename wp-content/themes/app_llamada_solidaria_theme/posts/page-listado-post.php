<?php
/*
	Name: Listado Post
*/
?>
<?php get_header(); ?>

<?php
require_once(get_template_directory()."/posts/clases/categoria.php");
require_once(get_template_directory()."/posts/clases/entrada.php");
?>

<main id="main">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1>Listado de Posts</h1> 

					<form class="buscador" method="post">
						<input type="search" name="query">
						<input class="btn btn-primary btn-sm" name="buscar_post" type="submit" value="Buscar">
					</form><br>

					<?php			
					if (is_user_logged_in()) {
						if(isset($_POST['borrar_post'])){
							$clase = new Entrada;
							$id = $_POST['id'];
							$entrada = $clase->get($id);
							$user_id = get_current_user_id();
							if ($user_id == $entrada->autor_id || is_admin_user()) {
							    // Eliminar la entrada de la base de datos
							    $entrada = $clase->delete($id);
							    wp_redirect(get_permalink(7));
							}else{
								wp_redirect(get_permalink(7));
							}
						}
					}					
					?>

					<?php
					$clase = new Entrada;
					$entradas = $clase->getAll();
					
					if(isset($_POST['buscar_post'])){
						$query = $_POST['query'];
						$entradas = $clase->search($query);
					}
					?>

					<div class="row">
						<?php
						foreach ($entradas as $entrada) { ?>
							<div class="col-12 col-lg-6">
								<div class="post">
									<?php
									// Autor
									$tabla_usuarios = $wpdb->users;
									$id = $entrada->autor_id;
									$autor = $wpdb->get_row( "SELECT * FROM $tabla_usuarios WHERE id = $id" );

									// Categoria									
									$clase2 = new Categoria;
									$categoria = $clase2->get($entrada->categoria_id);
									$fecha = strtotime($entrada->fecha);	

									echo "<h3>". $entrada->titulo ."</h2>";
									echo "<p><b>Autor: ". $autor->user_nicename ."</b></p>";
									echo "<p>". $entrada->contenido ."</p>";
									echo "<p>Categoria: ". $categoria->nombre ."</p>";
									echo "<p>Fecha: ". date('d-m-Y', $fecha) ."</p>";

									$user_id = get_current_user_id();

									if ((is_user_logged_in() && ($user_id == $entrada->autor_id)) || 
										is_admin_user()) { 
										$genre_url = add_query_arg('id', $entrada->id, get_permalink(14));
									?>
										<a class="btn btn-primary mb-3" href="<?php echo $genre_url; ?>">Editar</a>

										<form method="post">
											<input type="hidden" name="id" value="<?php echo $entrada->id;?>">
											<input type="submit" name="borrar_post" class="btn btn-danger" value="Borrar">
										</form>
									<?php
									} ?>
								</div><!--post-->
							</div><!--col-->
						<?php
						}?>
					</div><!--row-->
					<a class="btn btn-primary" href="<?php the_permalink(9) ?>">Crear Post</a>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();