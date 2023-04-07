<?php
namespace ProductImp\Database\Migrations;

class CreateProductsMappingTable
{
    public function __invoke($name, $charset)
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        $table = "CREATE TABLE $name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id varchar(255) NOT NULL,
            map varchar(15000) DEFAULT '{}' NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            PRIMARY KEY (id),
            UNIQUE KEY uq_product_id (product_id)
        ) $charset;";

        dbDelta( $table );
    }
}