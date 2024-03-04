<?php 

class Usuario{
	// Función para obtener un usuario por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuario = $wpdb->get_row( "SELECT * FROM $tabla_usuarios WHERE id = $id" );
	    return $usuario;
	}
	public function getByEmail( $email ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuario = $wpdb->get_row( "SELECT * FROM $tabla_usuarios WHERE email = '$email'" );
	    return $usuario;
	}
	public function getByDNI( $dni ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuario = $wpdb->get_row( "SELECT * FROM $tabla_usuarios WHERE dni = '$dni'" );
	    return $usuario;
	}
	public function getByPhone( $telefono ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuario = $wpdb->get_row( "SELECT * FROM $tabla_usuarios WHERE telefono = '$telefono'" );
	    return $usuario;
	}
	// Función para obtener todos los usuarios
	public function getAll() {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    $sql = "SELECT * FROM $tabla_usuarios";
	    $usuarios = $wpdb->get_results($sql);
	    return $usuarios;
	}
	// Función para obtener todos los usuarios que son profesionales
	public function getAllPrivilegedUsers() {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuarios = $wpdb->get_results( "SELECT * FROM $tabla_usuarios WHERE NOT rol_id = 1" );
	    return $usuarios;
	}
	// Función para obtener todos los usuarios que son profesionales
	public function getAllProfesionales() {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuarios = $wpdb->get_results( "SELECT * FROM $tabla_usuarios WHERE rol_id = 2" );
	    return $usuarios;
	}
	// Función para obtener todos los usuarios que son voluntarios
	public function getAllVoluntarios() {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Obtener el usuario de la base de datos
	    $usuarios = $wpdb->get_results( "SELECT * FROM $tabla_usuarios WHERE rol_id = 3" );
	    return $usuarios;
	}
	// Función para crear un usuario
	public function create( $params ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    $wpdb->insert( $tabla_usuarios, $params );
	    // Devolver el ID del nuevo usuario
	    return $wpdb->insert_id;
	}
	// Función para actualizar un usuario por ID
	public function update( $params, $id ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Actualizar la usuario en la base de datos
	    $wpdb->update( $tabla_usuarios, $params, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para eliminar un usuario por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	    // Eliminar la usuario de la base de datos
	    $wpdb->delete( $tabla_usuarios, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}

	// Función para buscar un usuario según el texto escrito
	public function searchByName($query){
		global $wpdb;
	   	$tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	   	$usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios WHERE nombre LIKE '%$query%' OR apellidos LIKE  '%$query%'");
	   	return $usuarios;
	}

	public function searchByGender($query){
		global $wpdb;
	   	$tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	   	$usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios WHERE genero LIKE '%$query%'");
	   	return $usuarios;
	}

	public function searchByPriority($query){
		global $wpdb;
	   	$tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	   	$usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios WHERE prioridad LIKE '%$query%'");
	   	return $usuarios;
	}

	public function searchByRol($query){
		global $wpdb;
	   	$tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
	   	$usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios WHERE rol_id LIKE '%$query%'");
	   	return $usuarios;
	}
	public function pagination($posts_per_page){
		global $wpdb;
		$tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
		$all_usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios");
		# Cuántos usuarios mostrar por página
		// Por defecto es la página 1; pero si está presente en la URL, tomamos esa
		$pagina = 1;
		if (isset($_GET["pagina"])) {
		    $pagina = $_GET["pagina"];
		}
		# El límite es el número de usuarios por página
		$limit = $posts_per_page;
		# El offset es saltar X usuarios que viene dado por multiplicar la página - 1 * los usuarios por página
		$offset = ($pagina - 1) * $posts_per_page;
		if(!empty($all_usuarios)){
			# Necesitamos el conteo para saber cuántas páginas vamos a mostrar
			$sentencia = $wpdb->get_results("SELECT count(*) AS conteo FROM $tabla_usuarios");
			$conteo = $sentencia[0]->conteo;
			# Para obtener las páginas dividimos el conteo entre los usuarios por página, y redondeamos hacia arriba
			$paginas = ceil($conteo / $posts_per_page);

			# Ahora obtenemos los usuarios usando ya el OFFSET y el LIMIT
			$usuarios = $wpdb->get_results("SELECT * FROM $tabla_usuarios LIMIT $limit OFFSET $offset");
			# Y más abajo los dibujamos...
			return [$usuarios, $pagina, $paginas];
		}
	}
}