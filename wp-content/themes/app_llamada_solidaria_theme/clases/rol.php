<?php 

class Rol{
	// Función para obtener un rol por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_roles = $wpdb->prefix . 'app_llamada_solidaria_roles';
	    // Obtener la rol de la base de datos
	    $rol = $wpdb->get_row( "SELECT * FROM $tabla_roles WHERE id = $id" );
	    return $rol;
	}

	public function getAll() {
	    global $wpdb;
	    $tabla_roles = $wpdb->prefix . 'app_llamada_solidaria_roles';
	    $sql = "SELECT * FROM $tabla_roles";
	    $roles = $wpdb->get_results($sql);
	    return $roles;
	}
}