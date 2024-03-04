<?php 

class Entrada{
	// Función para obtener un entrada por ID
	public function get( $id ) {
	    global $wpdb;
	    $tabla_entradas = $wpdb->prefix . 'entradas';
	    // Obtener la entrada de la base de datos
	    $entrada = $wpdb->get_row( "SELECT * FROM $tabla_entradas WHERE id = $id" );
	    return $entrada;
	}
	//
	public function getAll() {
	    global $wpdb;
	    $tabla_entradas = $wpdb->prefix . 'entradas';
	    $sql = "SELECT * FROM $tabla_entradas";
	    $entradas = $wpdb->get_results($sql);
	    return $entradas;
	}

	// Función para crear una entrada
	public function create( $params ) {
	    global $wpdb;
	    $tabla_entradas = $wpdb->prefix . 'entradas';
	    $wpdb->insert( $tabla_entradas, $params );
	    // Devolver el ID del nuevo entrada
	    return $wpdb->insert_id;
	}
	// Función para actualizar una entrada por ID
	public function update( $params, $id ) {
	    global $wpdb;
	    $tabla_entradas = $wpdb->prefix . 'entradas';
	    // Actualizar la entrada en la base de datos
	    $wpdb->update( $tabla_entradas, $params, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para eliminar una entrada por ID
	public function delete( $id ) {
	    global $wpdb;
	    $tabla_entradas = $wpdb->prefix . 'entradas';
	    // Eliminar la entrada de la base de datos
	    $wpdb->delete( $tabla_entradas, array( 'id' => $id ) );
	    // Devolver la cantidad de filas afectadas
	    return $wpdb->rows_affected;
	}
	// Función para buscar una entrada según el texto escrito
	public function search($query){
		global $wpdb;
	   	$tabla_entradas = $wpdb->prefix . 'entradas';
	   	$entradas = $wpdb->get_results("SELECT * FROM $tabla_entradas WHERE titulo LIKE '%$query%'");
	   	return $entradas;
	}
}