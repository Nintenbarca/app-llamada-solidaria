<?php
/*
	Template Name: Editar Actividad
*/
?>
<?php get_header(); ?>

<?php
require_once(get_template_directory()."/clases/actividad.php");
?>

<main id="main">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>

					<?php 
					$clase = new Actividad;
					$id = $_GET['id'];
					$actividad = $clase->get($id);


					if (is_user_logged_in() && is_admin_user()){
						if(isset($_POST['editar_actividad'])){
							if(!empty( $_FILES['imagen']['name'] ) ) {
								// WordPress environmet
								$path = preg_replace( '/wp-content.*$/', '', __DIR__ );
								require_once( $path . 'wp-load.php' );

								// it allows us to use wp_handle_upload() function
								require_once( ABSPATH . 'wp-admin/includes/file.php' );

								$upload = wp_handle_upload( 
									$_FILES[ 'imagen' ], 
									array( 'test_form' => false ) 
								);

								if( ! empty( $upload[ 'error' ] ) ) {
									wp_die( $upload[ 'error' ] );
								}

								// it is time to add our uploaded image into WordPress media library
								$attachment_id = wp_insert_attachment(
									array(
										'guid'           => $upload[ 'url' ],
										'post_mime_type' => $upload[ 'type' ],
										'post_title'     => basename( $upload[ 'file' ] ),
										'post_content'   => '',
										'post_status'    => 'inherit',
									),
									$upload[ 'file' ]
								);

								if( is_wp_error( $attachment_id ) || ! $attachment_id ) {
									wp_die( 'Upload error.' );
								}

								// update medatata, regenerate image sizes
								require_once( ABSPATH . 'wp-admin/includes/image.php' );

								wp_update_attachment_metadata(
									$attachment_id,
									wp_generate_attachment_metadata( $attachment_id, $upload[ 'file' ] )
								);
							}

							$titulo = $_POST['titulo'];
							$contenido = $_POST['contenido'];

							if(!empty( $_FILES['imagen']['name'] ) ){
								$old_imagen = $actividad->imagen;

								if(isset($old_imagen)){
									$imagen_id  = attachment_url_to_postid( $old_imagen );
									wp_delete_attachment($imagen_id, true);
								}

								$imagen = $upload[ 'url' ];
								$params = array(
									'titulo' => $titulo, 
									'contenido' => $contenido,
									'imagen' => $imagen
								);
							}else{
								$params = array(
									'titulo' => $titulo, 
									'contenido' => $contenido
								);
							}

							$clase->update($params, $id);
							wp_redirect(get_permalink(45));
						}						
					}else{
						wp_redirect(get_home_url());
					}?>

					<form method="post" enctype="multipart/form-data">
						<p><label for="titulo">Título: </label>
						<input class="form-control" type="text" id="titulo" name="titulo" value="<?php echo $actividad->titulo; ?>" maxlength="50" required></p>

						<p><label for="contenido">Contenido: </label>
						<textarea class="form-control" id="contenido" name="contenido" value="<?php echo $actividad->contenido; ?>" required><?php echo $actividad->contenido; ?></textarea></p>

						<?php 
						if (!empty($actividad->imagen)) { ?>
							<p><img src="<?php echo $actividad->imagen; ?>" width="250"></p>
						<?php 
						} ?>						
						<p><label for="imagen">Imagen: </label>
						<input class="form-control" type="file" id="imagen" name="imagen" value="<?php echo $actividad->imagen; ?>"></p>						
						<input type="submit" name="editar_actividad" class="btn btn-primary" value="Editar">
					</form>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>