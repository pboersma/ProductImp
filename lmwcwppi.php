<?php
/*
Plugin Name: Lycan Media - WooCommerce Wordpress Product Importer
*/

// Setup class autoloader
require_once dirname(__FILE__) . '/src/lmwcwppi/Autoloader.php';
lmwcwppi_Autoloader::register();

$lmwcwppi = new lmwcwppi_ProductImporter();
add_action('wp_loaded', array($lmwcwppi, 'load'));