<?php
/*
	Template Name: Home
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
?>

<main id="main">
	<section>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>

					<?php	
					//session_start();
					// Obtiene todos los usuarios
					$clase = new Usuario;
					$posts_per_page = 10;
					list($usuarios, $pagina, $paginas) = $clase->pagination($posts_per_page);

					// Borrar usuario si el usuario es administrador
					if (is_user_logged_in() && is_admin_user()) {
						if(isset($_POST['borrar_usuario'])){
							$clase = new Usuario;
							$id = $_POST['id'];
						    // Eliminar el usuario de la base de datos
						    $clase->delete($id);
						    // Redirige a la pagina actual
						    wp_redirect(get_permalink($current_page_id));
						}
					} ?>

					<!--Buscadores-->
					<div class="buscadores mb-4">
						<div class="row">
							<!--Añade los buscadores-->
							<?php include(get_template_directory().'/buscadores.php'); ?>

							<div class="col-12 col-lg-2">
								<form id="search_form" method="post">
									<select class="form-select" name="query_rol" onchange='this.form.submit()'>
										<?php 
										$clase2 = new Rol;
										$roles = $clase2->getAll();
										?>
										<option>Buscar por rol</option>
										<?php
										foreach($roles as $rol){ ?>
											<option value="<?php echo $rol->id ?>">
												<?php echo $rol->nombre; ?>
											</option>
										<?php 
										} ?>
									</select>
								</form>
							</div><!--col-->
						</div><!--row-->
					</div><!--buscadores-->

					<?php
					if ((is_user_logged_in() && is_admin_user()) || ($_SESSION['user']->rol_id == 2 || $_SESSION['user']->rol_id == 3)) { ?>
						<table class="table-list d-none d-lg-table">
							<tr>
								<th>Nombre</th>
								<th>Email</th>
								<th>Género</th>
								<th>DNI</th>
								<!--<th>Dirección</th>-->
								<th>Teléfono</th>
								<th>Nivel de prioridad</th>
								<th>Profesión</th>
								<th>Rol</th>
								<?php
								if ((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){ ?>
									<th>Acciones</th>
								<?php 
								} ?>
							</tr>

							<?php 
							if(!empty($usuarios)){
								foreach ($usuarios as $usuario) { 
									// Obtiene el rol con el usuario con su mismo id
									$clase2 = new Rol;
									$rol = $clase2->get($usuario->rol_id);
								?>
									<tr>
										<td><?php echo $usuario->nombre ." ". $usuario->apellidos ?></td>
										<td><?php echo $usuario->email ?></td>
										<td><?php echo $usuario->genero ?></td>
										<td><?php echo $usuario->dni ?></td>
										<!--<td><?php echo $usuario->direccion ?></td>-->
										<td><?php echo $usuario->telefono ?></td>
										<td><?php echo $usuario->prioridad ?></td>
										<td><?php echo $usuario->profesion ?></td>
										<td><?php echo $rol->nombre ?></td>
										<?php
										// Editar si el usuario es el mismo que se creó, o si es administrador
										if ((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){
											$genre_url = add_query_arg('id', $usuario->id, get_permalink(25));
										?>
											<td>							
												<div class="row">
													<div class="col-12 d-flex flex-wrap justify-content-center">
														<?php 
														if (is_user_logged_in() && is_admin_user()) { ?>
															<a class="btn btn-primary admin mb-lg-2 mb-xl-0" href="<?php echo $genre_url; ?>">Editar</a>
														<?php 
														}elseif(isset($_SESSION['user']) && $_SESSION['user']->id == $usuario->id){ ?>
															<a class="btn btn-primary" href="<?php echo $genre_url; ?>">Editar</a>
														<?php 
														}
														// Borrar si el usuario es administrador
														if(is_user_logged_in() && is_admin_user()){ ?>
															<form method="post">
																<input type="hidden" name="id" value="<?php echo $usuario->id;?>">
																<input type="submit" name="borrar_usuario" class="btn btn-danger" value="Borrar">
															</form>
														<?php
														}?>
													</div>
												</div>
											</td>
										<?php 
										} ?>
									</tr>
								<?php 
								} 
							}?>
						</table>

						<!--Listado de usuarios en móvil-->
						<div class="usuarios-list d-lg-none">
							<div class="row">
								<?php 
								if(!empty($usuarios)){
									foreach ($usuarios as $usuario) { ?>
										<div class="col-12 col-md-6">
											<div class="caption mb-4">
												<?php

												// Rol									
												$clase2 = new Rol;
												$rol = $clase2->get($usuario->rol_id);

												echo "<h3>". $usuario->nombre ." ". $usuario->apellidos ."</h3>";
												echo "<p>Email: ". $usuario->email ."</p>";
												echo "<p>Género: ". $usuario->genero ."</p>";
												echo "<p>DNI: ". $usuario->dni ."</p>";
												/*echo "<p>Dirección: ". $usuario->direccion ."</p>";*/
												echo "<p>Teléfono: ". $usuario->telefono ."</p>";
												if(!empty($usuario->prioridad)){
													echo "<p>Nivel de prioridad: ". $usuario->prioridad ."</p>";
												}
												if(!empty($usuario->profesion)){
													echo "<p>Profesión: ". $usuario->profesion ."</p>";
												}
												echo "<p><b>Rol: ". $rol->nombre ."</b></p>";

												// Editar si el usuario es el mismo que se creó, o si es administrador
												if ((is_user_logged_in() && is_admin_user()) || (isset($_SESSION['user']) && $_SESSION['user']->id == $usuario->id)){
													$genre_url = add_query_arg('id', $usuario->id, get_permalink(25));
												?>							
													<div class="row">
														<div class="col-12 d-flex flex-wrap">
															<a class="btn btn-primary" href="<?php echo $genre_url; ?>" style="margin-right: 10px;">Editar</a>
														
															<?php
															// Borrar si el usuario es administrador
															if(is_user_logged_in() && is_admin_user()){ ?>
																<form method="post">
																	<input type="hidden" name="id" value="<?php echo $usuario->id;?>">
																	<input type="submit" name="borrar_usuario" class="btn btn-danger" value="Borrar">
																</form>
															<?php
															}?>
														</div>
													</div>
												<?php 
												} ?>
											</div><!--post-->
										</div><!--col-->
									<?php
									}
								}?>
							</div><!--row-->
						</div><!--usuarios-list-->		
					<?php 
					}else{
						wp_redirect(get_permalink(88));
					}

					$all_usuarios = $clase->getAll();
					if (count($all_usuarios) > $posts_per_page) {
						include(get_template_directory().'/pagination.php');
					}?>

					<a class="btn btn-primary" href="<?php the_permalink(21) ?>">Crear Usuario</a>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>