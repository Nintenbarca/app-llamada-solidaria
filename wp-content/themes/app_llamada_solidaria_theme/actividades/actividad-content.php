<?php 
$fecha = strtotime($actividad->fecha);
$image = $actividad->imagen;

$actividad_url = add_query_arg('id', $actividad->id, get_permalink(70));
?>
<div class="actividad mb-4">
	<a href="<?php echo $actividad_url; ?>">
		<?php 
		if(isset($image)){ ?>
			<div class="thumb-container" style="background-image: url(<?php echo $image ?>);">
		<?php 
		}else{ ?>
			<div class="thumb-container" style="background-image: url('http://localhost/app_llamada_solidaria/wp-content/uploads/2024/02/Logo-AFA-Levante.png');">
		<?php 
		} ?>								
			<span class="btn btn-primary">Ver más</span>
		</div>
		<div class="caption">
			<h3><?php echo $actividad->titulo; ?></h3>
			<div><b><?php echo date('d-m-Y', $fecha); ?></b></div>
			<div class="mt-3"><?php echo wp_trim_words($actividad->contenido, 50); ?></div>
		</div>								
	</a>
	<?php
	if(is_user_logged_in() && is_admin_user()){ 
		$genre_url = add_query_arg('id', $actividad->id, get_permalink(60));
	?>
		<div class="d-flex flex-wrap mt-3">
			<a href="<?php echo $genre_url; ?>" class="btn btn-primary" style="margin-right: 10px;">Editar</a>

			<form method="post">
				<input type="hidden" name="id" value="<?php echo $actividad->id;?>">
				<input type="submit" name="borrar_actividad" class="btn btn-danger" value="Borrar">
			</form>
		</div>
	<?php 
	} ?>
</div>