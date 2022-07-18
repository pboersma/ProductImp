<?php
/*
Plugin Name: Product Imp - Woocommerce Product Importer.
*/

// Setup class autoloader
require_once dirname(__FILE__) . '/classes/Autoloader.php';
productimp_Autoloader::register(true);

$productimp = new productimp_ProductImporter();
register_activation_hook( __FILE__, array($productimp, 'setup'));
add_action('wp_loaded', array($productimp, 'load'));