<?php
/*
	Name: Editar Post
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
					<h1>Editar Post</h1>

					<?php 
					$clase = new Entrada;
					$id = $_GET['id'];
					$entrada = $clase->get($id);
					$user_id = get_current_user_id();

					if (is_user_logged_in()){
						if(isset($_POST['editar_post'])){
							if ($user_id == $entrada->autor_id || is_admin_user()){
								$titulo = $_POST['titulo'];
								$contenido = $_POST['contenido'];
								$categoria = $_POST['categoria_id'];

								$params = array(
							        'titulo' => $titulo,
							        'contenido' => $contenido,
							        'categoria_id' => $categoria
							    );
							    $clase->update($params, $id);
								wp_redirect(get_permalink(7));
							}
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

					$clase = new Entrada;
					$id = $_GET['id'];
					$entrada = $clase->get($id);
					$user_id = get_current_user_id();

					if (is_user_logged_in()) {
						if(isset($_POST['editar_post'])){
							if ($user_id == $entrada->autor_id || is_admin_user()) {
					    		if (!isset($_SESSION['errores'])) {
									$_SESSION['errores'] = array();
								}

								$titulo = $_POST['titulo'];
								$contenido = $_POST['contenido'];
								$categoria = $_POST['categoria_id'];

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
								    $params = array(
								        'titulo' => $titulo,
								        'contenido' => $contenido,
								        'categoria_id' => $categoria
								    );
								    $clase->update($params, $id);
									wp_redirect(get_permalink(7));
									
								}else{
									$genre_url = add_query_arg('id', $entrada->id, get_permalink(14));
									wp_redirect($genre_url);
								}							
							}else{
								wp_redirect(get_permalink(7));
							}						
						}
					}else{
						wp_redirect(get_permalink(7));
					}*/
					?>

					<form method="post">

						<input type="hidden" name="id" value="<?php echo $entrada->id;?>">

						<p><label for="titulo">Titulo: </label>
						<input type="text" name="titulo" value="<?php echo $entrada->titulo;?>" minlength="3" required></p>

						<p><label for="contenido">Contenido: </label>
						<textarea name="contenido" value="<?php echo $entrada->contenido;?>" maxlength="200" required><?php echo $entrada->contenido; ?></textarea>
						</p>

						<p><label for="categoria_id">Categoria: </label>
						<select name="categoria_id" required>

						<?php
			    		$clase2 = new Categoria;
			    		$categorias = $clase2->getAll();

						foreach ($categorias as $categoria) {
						
							echo '<option value="'.$categoria->id.'"';
							if($categoria->id == $entrada->categoria_id){
								echo ' selected';
							}
							echo '>';
							echo $categoria->nombre;
							echo '</option>';
						}
						?>
						</select></p>

						<input type="submit" name="editar_post" class="btn btn-primary" value="Guardar">
					</form>
					<a class="btn btn-primary mt-3" href="<?php the_permalink(7) ?>">Volver al listado</a>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</section>
</main>