<?php 

class Familiar{
	// Función para obtener un familiar por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Obtener el familiar de la base de datos
	    $familiar = $wpdb->get_row( "SELECT * FROM $tabla_familiares WHERE id = $id" );
	    return $familiar;
	}
	public function getByEmail( $email ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Obtener el familiar de la base de datos
	    $familiar = $wpdb->get_row( "SELECT * FROM $tabla_familiares WHERE email = '$email'" );
	    return $familiar;
	}
	public function getByDNI( $dni ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Obtener el familiar de la base de datos
	    $familiar = $wpdb->get_row( "SELECT * FROM $tabla_familiares WHERE dni = '$dni'" );
	    return $familiar;
	}
	public function getByPhone( $telefono ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Obtener el familiar de la base de datos
	    $familiar = $wpdb->get_row( "SELECT * FROM $tabla_familiares WHERE telefono = '$telefono'" );
	    return $familiar;
	}
	//
	public function getAll() {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    $sql = "SELECT * FROM $tabla_familiares";
	    $familiares = $wpdb->get_results($sql);
	    return $familiares;
	}
	public function getByUser($user_id){
		global $wpdb;
	   	$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	   	$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares WHERE user_id = $user_id");
	   	return $familiares;
	}

	// Función para crear un familiare
	public function create( $params ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    $wpdb->insert( $tabla_familiares, $params );
	    // Devolver el ID del nuevo familiar
	    return $wpdb->insert_id;
	}
	// Función para actualizar un familiare por ID
	public function update( $params, $id ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Actualizar el familiar en la base de datos
	    $wpdb->update( $tabla_familiares, $params, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para eliminar un familiare por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	    // Eliminar el familiar de la base de datos
	    $wpdb->delete( $tabla_familiares, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}

	// Función para buscar un familiar según el texto escrito
	public function searchByName($query){
		global $wpdb;
	   	$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	   	$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares WHERE nombre LIKE '%$query%' OR apellidos LIKE '%$query%'");
	   	return $familiares;
	}

	public function searchByGender($query){
		global $wpdb;
	   	$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	   	$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares WHERE genero LIKE '%$query%'");
	   	return $familiares;
	}

	public function searchByPriority($query){
		global $wpdb;
	   	$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	   	$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares WHERE prioridad LIKE '%$query%'");
	   	return $familiares;
	}	

	public function searchByUser($query){
		global $wpdb;
	   	$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
	   	$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares WHERE user_id LIKE '%$query%'");
	   	return $familiares;
	}
	public function pagination($posts_per_page){
		global $wpdb;
		$tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
		$all_familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares");
		# Cuántos familiares mostrar por página
		// Por defecto es la página 1; pero si está presente en la URL, tomamos esa
		$pagina = 1;
		if (isset($_GET["pagina"])) {
		    $pagina = $_GET["pagina"];
		}
		# El límite es el número de familiares por página
		$limit = $posts_per_page;
		# El offset es saltar X familiares que viene dado por multiplicar la página - 1 * los familiares por página
		$offset = ($pagina - 1) * $posts_per_page;
		if(!empty($all_familiares)){
			# Necesitamos el conteo para saber cuántas páginas vamos a mostrar
			$sentencia = $wpdb->get_results("SELECT count(*) AS conteo FROM $tabla_familiares");
			$conteo = $sentencia[0]->conteo;
			# Para obtener las páginas dividimos el conteo entre los familiares por página, y redondeamos hacia arriba
			$paginas = ceil($conteo / $posts_per_page);

			# Ahora obtenemos los familiares usando ya el OFFSET y el LIMIT
			$familiares = $wpdb->get_results("SELECT * FROM $tabla_familiares LIMIT $limit OFFSET $offset");
			# Y más abajo los dibujamos...
			return [$familiares, $pagina, $paginas];
		}
	}
}