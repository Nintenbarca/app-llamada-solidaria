<?php 

class Actividad{
	// Función para obtener un actividad por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	    // Obtener el actividad de la base de datos
	    $actividad = $wpdb->get_row( "SELECT * FROM $tabla_actividades WHERE id = $id" );
	    return $actividad;
	}
	// Función para obtener todos los actividads
	public function getAll() {
	    global $wpdb;
	    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	    $sql = "SELECT * FROM $tabla_actividades";
	    $actividades = $wpdb->get_results($sql);
	    return $actividades;
	}
	// Función para crear un actividad
	public function create( $params ) {
	    global $wpdb;
	    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	    $wpdb->insert( $tabla_actividades, $params );
	    // Devolver el ID del nuevo actividad
	    return $wpdb->insert_id;
	}
	// Función para actualizar un actividad por ID
	public function update( $params, $id ) {
	    global $wpdb;
	    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	    // Actualizar la actividad en la base de datos
	    $wpdb->update( $tabla_actividades, $params, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para eliminar un actividad por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	    // Eliminar la actividad de la base de datos
	    $wpdb->delete( $tabla_actividades, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para buscar un actividad según el texto escrito
	public function search($query){
		global $wpdb;
	   	$tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
	   	$actividades = $wpdb->get_results("SELECT * FROM $tabla_actividades WHERE titulo LIKE '%$query%'");
	   	return $actividades;
	}
	public function pagination($posts_per_page){
		global $wpdb;
		$tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
		$all_actividades = $wpdb->get_results("SELECT * FROM $tabla_actividades");
		# Cuántos actividades mostrar por página
		// Por defecto es la página 1; pero si está presente en la URL, tomamos esa
		$pagina = 1;
		if (isset($_GET["pagina"])) {
		    $pagina = $_GET["pagina"];
		}
		# El límite es el número de actividades por página
		$limit = $posts_per_page;
		# El offset es saltar X actividades que viene dado por multiplicar la página - 1 * los actividades por página
		$offset = ($pagina - 1) * $posts_per_page;
		if(!empty($all_actividades)){
			# Necesitamos el conteo para saber cuántas páginas vamos a mostrar
			$sentencia = $wpdb->get_results("SELECT count(*) AS conteo FROM $tabla_actividades");
			$conteo = $sentencia[0]->conteo;
			# Para obtener las páginas dividimos el conteo entre los actividades por página, y redondeamos hacia arriba
			$paginas = ceil($conteo / $posts_per_page);

			# Ahora obtenemos los actividades usando ya el OFFSET y el LIMIT
			$actividades = $wpdb->get_results("SELECT * FROM $tabla_actividades LIMIT $limit OFFSET $offset");
			# Y más abajo los dibujamos...
			return [$actividades, $pagina, $paginas];
		}
	}
}