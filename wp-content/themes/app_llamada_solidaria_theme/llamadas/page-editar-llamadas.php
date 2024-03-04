<?php
/*
	Template Name: Editar Llamada
*/
?>
<?php get_header(); ?>

<?php
require_once(get_template_directory()."/clases/usuario.php");
require_once(get_template_directory()."/clases/llamada.php");
?>

<main id="main">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>

					<?php
					$clase = new Llamada;
					$id = $_GET['id'];
					$llamada = $clase->get($id);

					if ((is_user_logged_in() && is_admin_user()) || 
						(isset($_SESSION['user']) && $_SESSION['user']->id == $llamada->user_id)){
						if(isset($_POST['editar_llamada'])){
							$impresiones = $_POST['impresiones'];

							if(is_user_logged_in() && is_admin_user()){
								$user_id = $_POST['user_id'];
							}else{
								$user_id = $_SESSION['user']->id;
							}						

							$params = array(
								'user_id' => $user_id,
								'impresiones' => $impresiones,
							);

							$clase->update($params, $id);
						    wp_redirect(get_permalink(82));
						}
					}else{
						wp_redirect(get_home_url());
					} ?>

					<form method="post">
						<input type="hidden" name="id" value="<?php echo $llamada->id;?>">
						<?php 
						if (is_user_logged_in() && is_admin_user()){ ?>
							<p><label for="user_id">Voluntario: </label>
							<select class="form-select" id="user_id" name="user_id">
								<?php
								$clase2 = new Usuario;
								$voluntarios = $clase2->getAllVoluntarios();

								foreach ($voluntarios as $voluntario) { ?>
									<option value="<?php echo $voluntario->id ?>"
										<?php
										if($voluntario->id == $llamada->user_id){ ?>
											selected
										<?php
										}?>
									>
										<?php echo $voluntario->nombre." ".$voluntario->apellidos;?>
									</option>
								<?php 
								}?>
							</select></p>
						<?php 
						} ?>
						<p><label for="impresiones">Impresiones: </label>
						<textarea class="form-control" id="impresiones" name="impresiones" value="<?php echo $llamada->impresiones;?>" required><?php echo $llamada->impresiones;?></textarea></p>
						<input type="submit" name="editar_llamada" class="btn btn-primary" value="Editar">
					</form>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();
?>