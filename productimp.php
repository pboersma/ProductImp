<?php
/** 
* @package ProductImp 
*/
/**
 * Plugin Name: Product Imp - Woocommerce Product Importer.
 * 
 * Description: A plugin written to import products for a woocommerce store through a custom datasource url.
 * Plugin URI: https://boersma.dev/wordpress/productimp 
 * Version: 1.0.0 
 * 
 * Author: Peter Boersma
 * Author URI: https://boersma.dev/wordpress
 * Text Domain: productimp 
 */
include_once  __DIR__ . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/Autoloader.php';
productimp_Autoloader::register();

$productimp = new productimp_ProductImporter();

register_activation_hook( __FILE__, array($productimp, 'setup'));
add_action('wp_loaded', array($productimp, 'load'));