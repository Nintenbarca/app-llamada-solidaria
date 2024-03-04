<?php
/*
	Template Name: Mis datos
*/
?>
<?php get_header(); ?>

<?php
// ID de la pagina actual
global $post;
$current_page_id = $post->ID;

// Obtiene las clases de rol y usuario
require_once(get_template_directory()."/clases/rol.php");
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
					$clase = new Usuario;
					$id = $_SESSION['user']->id;
					$usuario = $clase->get($id);

					if ($_SESSION['user']) { ?>	
						<div class="usuarios-list">
							<div class="row">
								<div class="col-12">
									<div class="caption mb-4">
										<?php
										// Rol									
										$clase2 = new Rol;
										$rol = $clase2->get($usuario->rol_id);

										echo "<h3>". $usuario->nombre ." ". $usuario->apellidos ."</h3>";
										echo "<p>Email: ". $usuario->email ."</p>";
										echo "<p>Género: ". $usuario->genero ."</p>";
										echo "<p>DNI: ". $usuario->dni ."</p>";
										echo "<p>Dirección: ". $usuario->direccion ."</p>";
										echo "<p>Teléfono: ". $usuario->telefono ."</p>";
										if(!empty($usuario->prioridad)){
											echo "<p>Nivel de prioridad: ". $usuario->prioridad ."</p>";
										}
										if(!empty($usuario->profesion)){
											echo "<p>Profesión: ". $usuario->profesion ."</p>";
										}
										echo "<p><b>Rol: ". $rol->nombre ."</b></p>";

										// Editar si el usuario es el mismo que se creó, o si es administrador
										
										$genre_url = add_query_arg('id', $usuario->id, get_permalink(25)); ?>
										
										<a class="btn btn-primary" href="<?php echo $genre_url; ?>">Editar</a>
									</div><!--post-->
								</div><!--col-->
							</div><!--row-->
						</div><!--usuarios-list-->

						<?php 
						$clase3 = new Familiar;
						$familiares = $clase3->getByUser($id);

						if(!empty($familiares)){?>
							<!--Listado de familiares-->
							<div class="usuarios-list">
								<h2>Familiares</h2>
								<div class="row">
									<?php 
									$clase3 = new Familiar;
									$familiares = $clase3->getByUser($id);
									foreach ($familiares as $familiar) { ?>
										<div class="col-12 col-md-6">
											<div class="caption mb-4">
												<?php

												// Rol									
												$clase2 = new Usuario;
												$usuario = $clase2->get($familiar->user_id);

												echo "<h3>". $familiar->nombre ." ". $familiar->apellidos ."</h3>";
												echo "<p>Email: ". $familiar->email ."</p>";
												echo "<p>Género: ". $familiar->genero ."</p>";
												echo "<p>DNI: ". $familiar->dni ."</p>";
												echo "<p>DNI: ". $familiar->parentesco ."</p>";
												echo "<p>Dirección: ". $familiar->direccion ."</p>";
												echo "<p>Teléfono: ". $familiar->telefono ."</p>";
												if(!empty($familiar->prioridad)){
													echo "<p>Nivel de prioridad: ". $familiar->prioridad ."</p>";
												}
												echo "<p><b>Familiar: ". $usuario->nombre ." ". $usuario->apellidos."</b></p>";
												
												$genre_url = add_query_arg('id', $familiar->id, get_permalink(38)); ?>
												<a class="btn btn-primary" href="<?php echo $genre_url; ?>">Editar</a>
											</div><!--post-->
										</div><!--col-->
									<?php
									} ?>
								</div><!--row-->
							</div><!--usuarios-list-->
						<?php 
						}
					}else{
						wp_redirect(get_permalink(45));
					} ?>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>