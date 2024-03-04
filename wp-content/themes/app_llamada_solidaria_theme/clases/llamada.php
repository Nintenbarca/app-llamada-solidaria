<?php 

class Llamada{
	// Función para obtener una llamada por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	    // Obtener el llamada de la base de datos
	    $llamada = $wpdb->get_row( "SELECT * FROM $tabla_llamadas WHERE id = $id" );
	    return $llamada;
	}
	//
	public function getAll() {
	    global $wpdb;
	    $tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	    $sql = "SELECT * FROM $tabla_llamadas";
	    $llamadas = $wpdb->get_results($sql);
	    return $llamadas;
	}
	// Función para crear una llamada
	public function create( $params ) {
	    global $wpdb;
	    $tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	    $wpdb->insert( $tabla_llamadas, $params );
	    // Devolver el ID del nuevo llamada
	    return $wpdb->insert_id;
	}
	// Función para actualizar una llamada por ID
	public function update( $params, $id ) {
	    global $wpdb;
	    $tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	    // Actualizar el llamada en la base de datos
	    $wpdb->update( $tabla_llamadas, $params, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para eliminar una llamada por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	    // Eliminar el llamada de la base de datos
	    $wpdb->delete( $tabla_llamadas, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	public function searchByUser($query){
		global $wpdb;
	   	$tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
	   	$llamadas = $wpdb->get_results("SELECT * FROM $tabla_llamadas WHERE user_id LIKE '%$query%'");
	   	return $llamadas;
	}
	public function pagination($posts_per_page){
		global $wpdb;
		$tabla_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
		$all_llamadas = $wpdb->get_results("SELECT * FROM $tabla_llamadas");
		# Cuántos llamadas mostrar por página
		// Por defecto es la página 1; pero si está presente en la URL, tomamos esa
		$pagina = 1;
		if (isset($_GET["pagina"])) {
		    $pagina = $_GET["pagina"];
		}
		# El límite es el número de llamadas por página
		$limit = $posts_per_page;
		# El offset es saltar X llamadas que viene dado por multiplicar la página - 1 * los llamadas por página
		$offset = ($pagina - 1) * $posts_per_page;
		if(!empty($all_llamadas)){
			# Necesitamos el conteo para saber cuántas páginas vamos a mostrar
			$sentencia = $wpdb->get_results("SELECT count(*) AS conteo FROM $tabla_llamadas");
			$conteo = $sentencia[0]->conteo;
			# Para obtener las páginas dividimos el conteo entre los llamadas por página, y redondeamos hacia arriba
			$paginas = ceil($conteo / $posts_per_page);

			# Ahora obtenemos los llamadas usando ya el OFFSET y el LIMIT
			$llamadas = $wpdb->get_results("SELECT * FROM $tabla_llamadas LIMIT $limit OFFSET $offset");
			# Y más abajo los dibujamos...
			return [$llamadas, $pagina, $paginas];
		}		
	}
}