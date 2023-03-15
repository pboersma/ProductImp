<?php
namespace ProductImp\Database\Migrations;

class CreateProductsWoocommerceTable
{
    public function __invoke($name, $charset)
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        $table = "CREATE TABLE $name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id varchar(255) NOT NULL,
            woocommerce_product_id varchar(255) NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            PRIMARY KEY  (id)
        ) $charset;";

        dbDelta( $table );
    }
}