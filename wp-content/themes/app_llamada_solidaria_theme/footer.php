<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package llamada-solidaria-theme
 */

?>
<?php
require_once(get_template_directory()."/clases/usuario.php");
?>
	<?php 
	if (is_user_logged_in() && is_admin_user()){ 
		$clase = new Usuario;
		$profesionales = $clase->getAllPrivilegedUsers();

		if(!empty($profesionales)){ ?>
			<section>
				<div class="container">
					<div class="row">
						<div class="col-12">
							<h3>Enviar notificación a un usuario</h3>
							<form action="<?php the_permalink(40); ?>" method="post">
								<div class="input-group">
									<select class="form-select" name="user_email">
										<?php
										foreach($profesionales as $profesional){ ?>
											<option value="<?php echo $profesional->email ?>"><?php echo $profesional->nombre. " " .$profesional->apellidos ?></option>
										<?php 
										} ?>
									</select>
									<input class="btn btn-primary" type="submit" value="Enviar">
								</div><!--input-group-->	
							</form>
						</div><!--col-->
					</div><!--row-->
				</div><!--container-->
			</section>	
		<?php 
		}
	}?>

	<?php /*
	<footer id="colophon" class="site-footer">
		<div class="site-info">
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'llamada-solidaria-theme' ) ); ?>">
				<?php
				printf( esc_html__( 'Proudly powered by %s', 'llamada-solidaria-theme' ), 'WordPress' );
				?>
			</a>
			<span class="sep"> | </span>
				<?php
				printf( esc_html__( 'Theme: %1$s by %2$s.', 'llamada-solidaria-theme' ), 'llamada-solidaria-theme', '<a href="http://underscores.me/">Underscores.me</a>' );
				?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
	*/ ?>
</div><!-- #page -->

<?php wp_footer(); ?>

<!--
<script type="text/javascript">
	$("form").validate({
	    lang: 'es' // textos en español
	});
</script>
-->

</body>
</html>
