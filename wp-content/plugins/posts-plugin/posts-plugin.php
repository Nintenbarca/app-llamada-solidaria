<?php

/*
Plugin Name: Posts Plugin
Description: Ejemplo de plugin
Version: 1.0
Author: Fabio
*/


// función para crear la tabla de categorias al activar el plugin
function crear_tabla_categorias() {
    global $wpdb;
    $tabla_categorias = $wpdb->prefix . 'categorias';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE $tabla_categorias (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(255),
        PRIMARY KEY (id)
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

// función para crear la tabla de entradas al activar el plugin
function crear_tabla_entradas() {
    global $wpdb;
    $tabla_entradas = $wpdb->prefix . 'entradas';
    $tabla_categorias = $wpdb->prefix . 'categorias';
    $tabla_usuarios = $wpdb->users;
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE $tabla_entradas (
        id INT NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(255),
        fecha DATE,
        autor_id bigint(20) UNSIGNED NOT NULL,
        contenido TEXT,
        categoria_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (id),       
        FOREIGN KEY (autor_id) REFERENCES $tabla_usuarios(id),
        FOREIGN KEY (categoria_id) REFERENCES $tabla_categorias(id)      

    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}
// Agregar la acción para crear la tabla de entradas al activar el plugin
register_activation_hook( __FILE__, 'crear_tabla_categorias' );
register_activation_hook( __FILE__, 'crear_tabla_entradas' );