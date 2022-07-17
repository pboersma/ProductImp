<?php
/*
Plugin Name: Product Imp - Woocommerce Product Importer.
*/

// Setup class autoloader
require_once dirname(__FILE__) . '/src/productimp/Autoloader.php';
productimp_Autoloader::register();

$productimp = new productimp_ProductImporter();
register_activation_hook( __FILE__, array($productimp, 'setup'));
add_action('wp_loaded', array($productimp, 'load'));