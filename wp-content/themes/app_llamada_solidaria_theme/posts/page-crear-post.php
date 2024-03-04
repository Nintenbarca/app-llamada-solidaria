<?php
/*
	Name: Crear Post
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
					<h1>Crear Post</h1>
					<?php 
					if (is_user_logged_in()) {
						if(isset($_POST['crear_post'])){
							$titulo = $_POST['titulo'];
							$fecha = date('Y-m-d');
							$autor_id = get_current_user_id();
							$contenido = $_POST['contenido'];
							$categoria_id = $_POST['categoria_id'];
							$entrada = new Entrada;
							$params = array(
								'titulo' => $titulo, 
								'fecha' => $fecha, 
								'autor_id' => $autor_id, 
								'contenido' => $contenido, 
								'categoria_id' => $categoria_id
							);
							$entrada->create($params);
						    wp_redirect(get_permalink(7));
						}
					}


					/*
					session_start();
					if (!empty($_SESSION['errores'])) {
						echo "<ul>";
						while (!empty($_SESSION['errores'])) {
							echo "<li>". array_pop($_SESSION['errores']) ."</li>";
						}
						echo "</ul>";
					}

					if (is_user_logged_in() || is_admin_user()) {
						if(isset($_POST['crear_post'])){
							if (!isset($_SESSION['errores'])) {
								$_SESSION['errores'] = array();
							}

							$titulo = $_POST['titulo'];
							$fecha = date('Y-m-d');
							$autor_id = get_current_user_id();
							$contenido = $_POST['contenido'];
							$categoria_id = $_POST['categoria_id'];

							if (empty($titulo)) {
								array_push($_SESSION['errores'], 'No he recibido el titulo');
							}elseif (strlen($titulo) < 3) {
								array_push($_SESSION['errores'], 'El titulo debe tener al menos 3 caracteres');
							}

							if (empty($contenido)) {
								array_push($_SESSION['errores'], 'No he recibido el contenido');
							}elseif (strlen($contenido) > 200) {
								array_push($_SESSION['errores'], 'El contenido no puede superar los 200 
									caracteres');
							}

							if (empty($_SESSION['errores'])) {
								$entrada = new Entrada;
								$params = array(
									'titulo' => $titulo, 
									'fecha' => $fecha, 
									'autor_id' => $autor_id, 
									'contenido' => $contenido, 
									'categoria_id' => $categoria_id
								);
								$entrada->create($params);
							    wp_redirect(get_permalink(7));
							}else{
								wp_redirect(get_permalink(9));
							}
						}
					}else{
						wp_redirect(get_permalink(7));
					}*/
					?>

					<form method="post">

						<p><label for="titulo">Titulo: </label>
						<input type="text" name="titulo" minlength="3" required></p>

						<p><label for="contenido">Contenido: </label>
						<textarea name="contenido" maxlength="200" required></textarea></p>

						<p><label for="categoria_id">Categoria: </label>
						<select name="categoria_id" required>
							<?php
							$clase = new Categoria;
							$categorias = $clase->getAll();

							foreach ($categorias as $categoria) {
								echo '<option value ="'.$categoria->id.'">'. $categoria->nombre .'</option>';
							}	
						
							?>
						</select></p>

						<input type="submit" name="crear_post" class="btn btn-primary" value="Enviar">
					</form>
					<a class="btn btn-primary mt-3" href="<?php the_permalink(7) ?>">Volver al listado</a>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>

<?php
get_footer();