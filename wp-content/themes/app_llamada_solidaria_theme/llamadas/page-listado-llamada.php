<?php
/*
	Template Name: Llamadas
*/
?>
<?php get_header(); ?>

<?php
global $post;
$current_page_id = $post->ID;

require_once(get_template_directory()."/clases/usuario.php");
require_once(get_template_directory()."/clases/llamada.php");
?>

<main id="main">
	<section>
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>

					<?php	
					//session_start();

					$clase = new Llamada;
					$posts_per_page = 10;					
					list($llamadas, $pagina, $paginas) = $clase->pagination($posts_per_page);
					
					if(isset($_POST['borrar_llamada'])){
						$clase = new Llamada;
						$id = $_POST['id'];
					    $clase->delete($id);
					    // Redirige a la pagina actual
					    wp_redirect(get_permalink($current_page_id));
					} 

					if(isset($_POST['crear_llamada'])){						
						$fecha = date('Y-m-d');
						$impresiones = $_POST['impresiones'];

						if(is_user_logged_in() && is_admin_user()){
							$user_id = $_POST['user_id'];
						}else{
							$user_id = $_SESSION['user']->id;
						}						

						$params = array(
							'user_id' => $user_id,
							'impresiones' => $impresiones,
							'fecha' => $fecha
						);

						$clase->create($params);
					    wp_redirect(get_permalink($current_page_id));
					}
					?>

					<div class="buscadores mb-3">
						<div class="row">
							<div class="col-12 col-lg-3">
								<form id="search_form" method="post">
									<select class="form-select" name="query_user" onchange='this.form.submit()'>
										<?php 
										
										$clase2 = new Usuario;
										$voluntarios = $clase2->getAllVoluntarios();
										?>
										<option>Buscar por voluntario</option>
										<?php
										foreach($voluntarios as $voluntario){ ?>
											<option value="<?php echo $voluntario->id ?>">
												<?php echo $voluntario->nombre. " " .$voluntario->apellidos?>
											</option>
										<?php 
										} ?>									
									</select>
								</form>
							</div><!--col-->
						</div><!--row-->
					</div><!--buscadores-->

					<?php 
					if(isset($_POST['query_user'])){
						$query = $_POST['query_user'];
						$llamadas = $clase->searchByUser($query);
						include(get_template_directory().'/search-form-update.php'); 
					}					
					
					if ((is_user_logged_in() && is_admin_user()) || ($_SESSION['user']->rol_id == 2 || $_SESSION['user']->rol_id == 3)) { ?>
						<table class="table-list d-none d-lg-table">
							<tr>
								<th>Voluntario</th>
								<th>Fecha</th>
								<th>Impresiones</th>
								<?php
								if((is_user_logged_in() && is_admin_user()) || (isset($_SESSION['user']))){?>
									<th>Acciones</th>
								<?php 
								} ?>
							</tr>

							<?php 
							if(!empty($llamadas)){
								foreach ($llamadas as $llamada) { 
									// Obtiene el usuario con el llamada con su mismo id
									$clase2 = new Usuario;
									$usuario = $clase2->get($llamada->user_id);
									$fecha = strtotime($llamada->fecha);
								?>
									<tr>
										<td><?php echo $usuario->nombre. " " .$usuario->apellidos?></td>
										<td><?php echo date('d-m-Y', $fecha); ?></td>
										<td><?php echo $llamada->impresiones ?></td>
										<?php
										// Editar si el llamada por el usuario logueado, o si es administrador
										if ((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){ 
											$genre_url = add_query_arg('id', $llamada->id, get_permalink(86));
										?>
											<td>
												<div class="row">
													<div class="col-12 d-flex flex-wrap justify-content-center">
														<?php 
														if ((is_user_logged_in() && is_admin_user()) || 
															(isset($_SESSION['user']) && $_SESSION['user']->id == $llamada->user_id)){
														?>		
															<a class="btn btn-primary admin mb-lg-2 mb-xl-0" href="<?php echo $genre_url; ?>">Editar</a>
															<form method="post">
																<input type="hidden" name="id" value="<?php echo $llamada->id;?>">
																<input type="submit" name="borrar_llamada" class="btn btn-danger" value="Borrar">
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

						<!--Listado de llamadas en móvil-->
						<div class="usuarios-list d-lg-none">
							<div class="row">
								<?php 
								if(!empty($llamadas)){
									foreach ($llamadas as $llamada) { ?>
										<div class="col-12 col-md-6">
											<div class="caption mb-4">
												<?php

												// Rol									
												$clase2 = new Usuario;
												$usuario = $clase2->get($llamada->user_id);
												$fecha = strtotime($llamada->fecha);

												echo "<p><b>Voluntario: ". $usuario->nombre ." ". $usuario->apellidos."</b></p>";
												echo "<p>Fecha: ". date('d-m-Y', $fecha) ."</p>";
												echo "<p>Impresiones:</p>";
												echo "<p>". $llamada->impresiones ."</p>";

												// Editar si el llamada es el mismo que se creó, o si es administrador
												if ((is_user_logged_in() && is_admin_user()) || (isset($_SESSION['user']) && $_SESSION['user']->id == $llamada->user_id)){
													$genre_url = add_query_arg('id', $llamada->id, get_permalink(86));
												?>							
													<div class="row">
														<div class="col-12 d-flex flex-wrap">
															<a class="btn btn-primary" href="<?php echo $genre_url; ?>" style="margin-right: 10px;">Editar</a>
															<form method="post">
																<input type="hidden" name="id" value="<?php echo $llamada->id;?>">
																<input type="submit" name="borrar_llamada" class="btn btn-danger" value="Borrar">
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
						$all_llamadas = $clase->getAll();
						if (count($all_llamadas) > $posts_per_page) {
							include(get_template_directory().'/pagination.php');
						}
						
						// Formulario para añadir llamada
						if(!empty($voluntarios)){
							/*if((is_user_logged_in() && is_admin_user()) || ($_SESSION['user']->rol_id == 3)){*/?>
								<h3>Añadir llamada</h3>
								<form id="llamada-form" method="post">
									<?php 
									if (is_user_logged_in() && is_admin_user()){?>
										<p><label for="user_id">Voluntarios: </label>
										<select class="form-select" id="user_id" name="user_id" required>
											<?php foreach($voluntarios as $voluntario){ ?>
												<option value="<?php echo $voluntario->id;?>">
													<?php echo $voluntario->nombre." ".$voluntario->apellidos;?>
												</option>
											<?php 
											} ?>
										</select></p>
									<?php	
									}?>
									<p><label for="impresiones">Impresiones: </label>
									<textarea class="form-control" id="impresiones" name="impresiones"></textarea></p>

									<input class="btn btn-primary" type="submit" name="crear_llamada" value="Añadir">
								</form>
							<?php 
							/*}*/
						}
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