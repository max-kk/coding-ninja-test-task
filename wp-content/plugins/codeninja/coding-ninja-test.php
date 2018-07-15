<?php
/**
Plugin Name:    Coding Ninja Test
Plugin URI:     #0
Description:    -
Version:        1.00
Author URI:     #0
Author:         Maxim K
 */

// If this file is called directly, abort.
if (!class_exists('WP')) {
    die();
}

if ( $_SERVER['SCRIPT_FILENAME'] == __FILE__ ) {
    die( 'Access denied.' );
}

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


add_action('plugins_loaded', function() {
    
    require "includes/woo-film.php";
    require "includes/post-type.php";
    require "includes/post-type-metabox.php";
    require "includes/woocommerce.php";
    require "includes/registration.php";

});