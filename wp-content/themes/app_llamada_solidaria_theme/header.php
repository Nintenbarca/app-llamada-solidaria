<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package llamada-solidaria-theme
 */

?>

<?php 
// Permite usar session_start() en la web
ob_start(); 
?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<style type="text/css">
	header ul.menu > li.users{
		display: none;
	}
	header ul.menu > li.familiar{
		display: none;
	}

	<?php
	//session_start();
	if ((is_user_logged_in() && is_admin_user()) || (isset($_SESSION['user']) && ($_SESSION['user']->rol_id == 2 || $_SESSION['user']->rol_id == 3))) { ?>
		header ul.menu > li.users{
			display: block;
		}
	<?php 
	}

	if (isset($_SESSION['user']) && $_SESSION['user']->rol_id == 1) { ?>
		header ul.menu > li.familiar{
			display: block;
		}
	<?php 
	} 

	if((is_user_logged_in() && is_admin_user()) || isset($_SESSION['user'])){ ?>
		header ul.menu > li.invitado{
			display: none;
		}
	<?php 
	}

	if ((is_user_logged_in() && is_admin_user()) || !isset($_SESSION['user'])) { ?>
		header ul.menu > li.mis-datos{
			display: none;
		}	
	<?php
	} ?>
</style>


<div id="page" class="site">
	<header>
		<div class="container-fluid">
			<div class="row align-items-center">				
				<div class="col-6 col-lg-9">
					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle btn btn-primary d-md-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menú', 'llamada-solidaria-theme' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'menu' => 'principal',
								'menu_class'        => 'menu'
							)
						);
						?>
					</nav><!-- #site-navigation -->
				</div><!--col-->
				<div class="col-6 col-lg-3 d-flex justify-content-end">
					<?php 
					if(is_user_logged_in() || isset($_SESSION['user'])){ ?>
						<a href="<?php echo wp_logout_url(get_home_url()); ?>" class="btn btn-danger">Cerrar Sesión</a>
					<?php
					}else{ ?>
						<a href="<?php the_permalink(23) ?>" class="btn btn-primary">Iniciar Sesión</a>
					<?php
					} ?>
				</div><!--col-->
			</div><!--row-->
		</div><!--container-->
	</header>
	<?php /*
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'llamada-solidaria-theme' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$llamada_solidaria_theme_description = get_bloginfo( 'description', 'display' );
			if ( $llamada_solidaria_theme_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $llamada_solidaria_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'llamada-solidaria-theme' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
	*/ ?>
