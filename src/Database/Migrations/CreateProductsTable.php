<?php
namespace ProductImp\Database\Migrations;

class CreateProductsTable
{
    public function __invoke($name, $charset)
    {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        
        $table = "CREATE TABLE $name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            datasource_id varchar(255) NOT NULL,
            ean varchar(255) NOT NULL,
            product varchar(15000) DEFAULT '{}' NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            PRIMARY KEY  (id),
            UNIQUE KEY uq_ean (ean)
        ) $charset;";

        dbDelta( $table );
    }
}