<?php
/*
	Template Name: Login Usuario
*/
?>
<?php get_header(); ?>

<?php
global $post;
$current_page_id = $post->ID;

require_once(get_template_directory()."/clases/usuario.php");
?>

<main id="main">
	<section>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<h1><?php the_title() ?></h1>
					<?php 
					//session_start();
					if(is_user_logged_in() || isset($_SESSION['user'])){
						wp_redirect(get_home_url());
					}
					
					if (!empty($_SESSION['errores'])) {
						echo "<ul>";
						while (!empty($_SESSION['errores'])) {
							echo "<li>". array_pop($_SESSION['errores']) ."</li>";
						}
						echo "</ul>";
					}

					if(isset($_POST['login_usuario'])){
						if (!isset($_SESSION['errores'])) {
							$_SESSION['errores'] = array();
						}

						$email = $_POST['email'];
						$pass = $_POST['pass'];

						$clase = new Usuario;
						$usuario = $clase->getByEmail($email);
						$usuario_pass = $usuario->pass;

						if(isset($usuario)){
							if ($usuario_pass == md5($pass)) {
								session_start();
								$_SESSION['user'] = $usuario;

								wp_redirect(get_home_url());							
							}else{
								array_push($_SESSION["errores"], "Email/contraseña incorrectos");
								wp_redirect(get_permalink($current_page_id));
							}
						}else{
							array_push($_SESSION["errores"], "Email/contraseña incorrectos");
							wp_redirect(get_permalink($current_page_id));
						}
					}					
					?>

					<form method="post">
						<p><label for="email">Email: </label>
						<input class="form-control" type="email" name="email" required></p>

						<p><label for="pass">Contraseña: </label>
						<input class="form-control" type="password" name="pass" required></p>

						<input type="submit" name="login_usuario" class="btn btn-primary" value="Login">
					</form>
					<!--<a class="btn btn-primary mt-3" href="<?php the_permalink(19) ?>">Volver al listado</a>-->
				</div>
			</div>
		</div>
	</section>
</main>

<?php
get_footer();
?>