<?php 

class RegistroActividad{
	// Función para obtener un registro por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    // Obtener el registro de la base de datos
	    $registro_actividad = $wpdb->get_row( "SELECT * FROM $tabla_registro_actividades WHERE id = $id" );
	    return $registro_actividad;
	}
	public function getRegistro( $actividad_id, $user_id ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    // Obtener el registro de la base de datos
	    $registro_actividad = $wpdb->get_row( "SELECT * FROM $tabla_registro_actividades WHERE actividad_id = $actividad_id AND user_id = $user_id" );
	    return $registro_actividad;
	}
	public function getByActividad( $actividad_id ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    // Obtener el registro de la base de datos
	    $registro_actividad = $wpdb->get_results( "SELECT * FROM $tabla_registro_actividades WHERE actividad_id = $actividad_id" );
	    return $registro_actividad;
	}
	public function getByUser( $user_id ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    // Obtener el registro de la base de datos
	    $registro_actividad = $wpdb->get_results( "SELECT * FROM $tabla_registro_actividades WHERE user_id = $user_id" );
	    return $registro_actividad;
	}
	// Función para obtener todos los registros
	public function getAll() {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    $sql = "SELECT * FROM $tabla_registro_actividades";
	    $registro_actividades = $wpdb->get_results($sql);
	    return $registro_actividades;
	}
	// Función para crear un registro
	public function create( $params ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    $wpdb->insert( $tabla_registro_actividades, $params );
	    // Devolver el ID del nuevo registro
	    return $wpdb->insert_id;
	}
	// Función para eliminar un registro por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
	    // Eliminar la actividade de la base de datos
	    $wpdb->delete( $tabla_registro_actividades, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
}