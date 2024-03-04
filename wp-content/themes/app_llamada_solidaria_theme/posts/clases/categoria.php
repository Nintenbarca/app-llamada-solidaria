<?php 

class Categoria{
	// Función para obtener una categoria por ID
	public function get( $request ) {
	    global $wpdb;
	    $tabla_categorias = $wpdb->prefix . 'categorias';
	    /*$id = $request['id'];*/
	    // Obtener la categoria de la base de datos
	    $categoria = $wpdb->get_row( "SELECT * FROM $tabla_categorias WHERE id = $request" );	    
	    return $categoria;
	}
	//
	public function getAll() {
	    global $wpdb;
	    $tabla_categorias = $wpdb->prefix . 'categorias';
	    $sql = "SELECT * FROM $tabla_categorias";
	    $categorias = $wpdb->get_results($sql);
	    return $categorias;
	}	
}