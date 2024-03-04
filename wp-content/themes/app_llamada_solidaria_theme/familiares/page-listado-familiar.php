<?php
/*
	Template Name: Familiares
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
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>						

					<?php	
					//session_start();

					$clase = new Familiar;
					$posts_per_page = 10;
					list($familiares, $pagina, $paginas) = $clase->pagination($posts_per_page);
					
					if(isset($_POST['borrar_familiar'])){
						$clase = new Familiar;
						$id = $_POST['id'];
					    $clase->delete($id);
					    // Redirige a la pagina actual
					    wp_redirect(get_permalink($current_page_id));
					} ?>

					<!--Buscadores-->
					<div class="buscadores mb-4">
						<div class="row">
							<?php include(get_template_directory().'/buscadores.php'); ?>

							<div class="col-12 col-lg-2">
								<form id="search_form" method="post">
									<select class="form-select" name="query_user" onchange='this.form.submit()'>
										<?php 
										
										$clase2 = new Usuario;
										$usuarios = $clase2->getAll();
										?>
										<option>Buscar por usuario</option>
										<?php
										foreach($usuarios as $usuario){ ?>
											<option value="<?php echo $usuario->id ?>">
												<?php echo $usuario->nombre. " " .$usuario->apellidos?>
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
								<th>Parentesco</th>
								<!--<th>Dirección</th>-->
								<th>Teléfono</th>
								<th>Nivel de prioridad</th>
								<th>Familiar</th>
								<?php
								if ((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){?>
									<th>Acciones</th>
								<?php 
								} ?>
							</tr>

							<?php 
							if(!empty($familiares)){
								foreach ($familiares as $familiar) { 
									// Obtiene el usuario con el familiar con su mismo id
									$clase2 = new Usuario;
									$usuario = $clase2->get($familiar->user_id);
								?>
									<tr>
										<td><?php echo $familiar->nombre ." ". $familiar->apellidos ?></td>
										<td><?php echo $familiar->email ?></td>
										<td><?php echo $familiar->genero ?></td>
										<td><?php echo $familiar->dni ?></td>
										<td><?php echo $familiar->parentesco ?></td>
										<!--<td><?php echo $familiar->direccion ?></td>-->
										<td><?php echo $familiar->telefono ?></td>
										<td><?php echo $familiar->prioridad ?></td>
										<td><?php echo $usuario->nombre. " " .$usuario->apellidos?></td>
										<?php
										// Editar si el familiar por el usuario logueado, o si es administrador
										if ((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){ 
											$genre_url = add_query_arg('id', $familiar->id, get_permalink(38));
										?>
											<td>
												<div class="row">
													<div class="col-12 d-flex flex-wrap justify-content-center">
														<?php 
														if ((is_user_logged_in() && is_admin_user()) || 
															(isset($_SESSION['user']) && $_SESSION['user']->id == $familiar->user_id)){
														?>
															<a class="btn btn-primary admin mb-lg-2 mb-xl-0" href="<?php echo $genre_url; ?>">Editar</a>
															<form method="post">
																<input type="hidden" name="id" value="<?php echo $familiar->id;?>">
																<input type="submit" name="borrar_familiar" class="btn btn-danger" value="Borrar">
															</form>
														<?php 
														} ?>
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

						<!--Listado de familiares en móvil-->
						<div class="usuarios-list d-lg-none">
							<div class="row">
								<?php 
								if(!empty($familiares)){
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
												/*echo "<p>Dirección: ". $familiar->direccion ."</p>";*/
												echo "<p>Teléfono: ". $familiar->telefono ."</p>";
												if(!empty($familiar->prioridad)){
													echo "<p>Nivel de prioridad: ". $familiar->prioridad ."</p>";
												}
												echo "<p><b>Familiar: ". $usuario->nombre ." ". $usuario->apellidos."</b></p>";

												// Editar si el familiar es el mismo que se creó, o si es administrador
												if ((is_user_logged_in() && is_admin_user()) || (isset($_SESSION['user']) && $_SESSION['user']->id == $familiar->user_id)){
													$genre_url = add_query_arg('id', $familiar->id, get_permalink(38));
												?>							
													<div class="row">
														<div class="col-12 d-flex flex-wrap">
															<a class="btn btn-primary" href="<?php echo $genre_url; ?>" style="margin-right: 10px;">Editar</a>
															<form method="post">
																<input type="hidden" name="id" value="<?php echo $familiar->id;?>">
																<input type="submit" name="borrar_familiar" class="btn btn-danger" value="Borrar">
															</form>
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
						$all_familiares = $clase->getAll();
						if (count($all_familiares) > $posts_per_page) {
							include(get_template_directory().'/pagination.php');
						}?>

						<a class="btn btn-primary" href="<?php the_permalink(36) ?>">Añadir Familiar</a>
					<?php
					}else{
						wp_redirect(get_home_url());
					}?>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>