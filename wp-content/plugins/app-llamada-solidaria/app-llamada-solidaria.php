<?php

/*
Plugin Name: App llamada solidaria
Description: Creación de tablas para la app
Version: 1.0
Author: Fabio
*/

function crear_tabla_roles() {
    global $wpdb;
    $tabla_roles = $wpdb->prefix . 'app_llamada_solidaria_roles';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_roles (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(255),
        PRIMARY KEY (id)
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

function insertar_tabla_roles() {
    global $wpdb;
    $tabla_roles = $wpdb->prefix . 'app_llamada_solidaria_roles';
    $sql = "SELECT * FROM $tabla_roles";
    $roles = $wpdb->get_results($sql);
    // Definir la estructura de la tabla
    if(empty($roles)){
        $rows_affected = $wpdb->insert( $tabla_roles, array( 'nombre' => 'Cliente' ));
        $rows_affected2 = $wpdb->insert( $tabla_roles, array( 'nombre' => 'Profesional' ));
        $rows_affected3 = $wpdb->insert( $tabla_roles, array( 'nombre' => 'Voluntario' ));

        // Incluir el archivo necesario para ejecutar dbDelta()
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $rows_affected );
        dbDelta( $rows_affected2 );
        dbDelta( $rows_affected3 );
    }    
}

function crear_tabla_usuarios() {
    global $wpdb;
    $tabla_roles = $wpdb->prefix . 'app_llamada_solidaria_roles';
    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_usuarios (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(100),
        apellidos VARCHAR(255),
        email VARCHAR(255) UNIQUE KEY,
        pass VARCHAR(100),
        genero VARCHAR(100),
        dni VARCHAR(100) UNIQUE KEY,
        direccion VARCHAR(255),
        telefono VARCHAR(50) UNIQUE KEY,
        prioridad INT NOT NULL DEFAULT 0,
        profesion VARCHAR(255),
        rol_id INT UNSIGNED NOT NULL DEFAULT 1,
        PRIMARY KEY (id),
        FOREIGN KEY (rol_id) REFERENCES $tabla_roles(id) ON UPDATE CASCADE ON DELETE CASCADE   
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

function crear_tabla_familiares() {
    global $wpdb;
    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
    $tabla_familiares = $wpdb->prefix . 'app_llamada_solidaria_familiares';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_familiares (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(255),
        apellidos VARCHAR(255),
        parentesco VARCHAR(100),
        email VARCHAR(255) UNIQUE KEY,
        genero VARCHAR(100),        
        dni VARCHAR(100) UNIQUE KEY,
        direccion VARCHAR(255),
        telefono VARCHAR(50) UNIQUE KEY,
        prioridad INT NOT NULL DEFAULT 0,
        user_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES $tabla_usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

function crear_tabla_lista_llamadas() {
    global $wpdb;
    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
    $tabla_lista_llamadas = $wpdb->prefix . 'app_llamada_solidaria_lista_llamadas';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_lista_llamadas (
        id INT NOT NULL AUTO_INCREMENT,
        user_id INT UNSIGNED NOT NULL,
        impresiones TEXT,
        fecha DATE,        
        PRIMARY KEY (id),
        FOREIGN KEY (user_id) REFERENCES $tabla_usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

function crear_tabla_actividades() {
    global $wpdb;
    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_actividades (
        id INT UNSIGNED NOT NULL AUTO_INCREMENT,
        titulo VARCHAR(100),
        contenido TEXT,
        imagen VARCHAR(255),
        fecha DATE,
        PRIMARY KEY (id)
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}

function crear_tabla_registro_actividades() {
    global $wpdb;
    $tabla_usuarios = $wpdb->prefix . 'app_llamada_solidaria_usuarios';
    $tabla_actividades = $wpdb->prefix . 'app_llamada_solidaria_actividades';
    $tabla_registro_actividades = $wpdb->prefix . 'app_llamada_solidaria_registro_actividades';
    // Definir la estructura de la tabla
    $sql = "CREATE TABLE IF NOT EXISTS $tabla_registro_actividades (
        id INT NOT NULL AUTO_INCREMENT,
        actividad_id INT UNSIGNED NOT NULL,
        user_id INT UNSIGNED NOT NULL,
        PRIMARY KEY (id),
        FOREIGN KEY (actividad_id) REFERENCES $tabla_actividades(id) ON UPDATE CASCADE ON DELETE CASCADE,
        FOREIGN KEY (user_id) REFERENCES $tabla_usuarios(id) ON UPDATE CASCADE ON DELETE CASCADE
    )";
    // Incluir el archivo necesario para ejecutar dbDelta()
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    // Crear o modificar la tabla en la base de datos
    dbDelta( $sql );
}


// Agregar la acción para crear las tablas al activar el plugin
register_activation_hook( __FILE__, 'crear_tabla_roles' );
register_activation_hook( __FILE__, 'insertar_tabla_roles' );
register_activation_hook( __FILE__, 'crear_tabla_usuarios' );
register_activation_hook( __FILE__, 'crear_tabla_familiares' );
register_activation_hook( __FILE__, 'crear_tabla_lista_llamadas' );
register_activation_hook( __FILE__, 'crear_tabla_actividades' );
register_activation_hook( __FILE__, 'crear_tabla_registro_actividades' );