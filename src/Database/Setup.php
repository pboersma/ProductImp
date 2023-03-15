<?php
namespace ProductImp\Database;

class Setup
{
    private $tables = [
        'pi_datasources'            => 'ProductImp\Database\Migrations\CreateDatasourcesTable',
        'pi_products'               => 'ProductImp\Database\Migrations\CreateProductsTable',
        'pi_products_mapping'       => 'ProductImp\Database\Migrations\CreateProductsMappingTable',
        'pi_products_woocommerce'   => 'ProductImp\Database\Migrations\CreateProductsWoocommerceTable'
    ];

    /**
     * Create all Database tables for Wordpress according to the $tables variable.
     * 
     * @return void
     */
    public function create()
    {
        global $wpdb;

        foreach($this->tables as $table_name => $class) {
            call_user_func(
                [ new $class, '__invoke' ], 
                $wpdb->prefix . $table_name, 
                $wpdb->get_charset_collate()
            );
        }
        
        add_option('pi_db_version', '1.0.0');
    }
}