<?php

/*
 * Plugin Name:     Movie Database
 * Plugin URI:      /
 * Version:         1.0.0
 * Author:          David Gubik
 * Domain Path:     /languages
 */

if(!defined('ABSPATH')){
    exit;
}

define('MVDB_VERSION', '1.0.0');

define('MVDB_PLUGIN', plugin_dir_path(__FILE__));

function mvdb_activate(): void
{
    require_once plugin_dir_path(__FILE__) . 'includes/class-movie-database-activator.php';
    MVDB_Activator::activate();
}

function mvdb_deactivate(): void
{
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-movie-database-deactivator.php';
    MVDB_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'mvdb_activate');
register_deactivation_hook(__FILE__, 'mvdb_deactivate');

require_once MVDB_PLUGIN . 'includes/class-movie-database.php';
$mvdb = new MVDB_Init();
$mvdb->run();