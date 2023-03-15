<?php
namespace ProductImp\Database;

class Setup
{
    private $tables = [
        'pi_datasources' => "ProductImp\\Database\\Migrations\\CreateDatasourcesTable"
    ];

    /**
     * Create all Database tables for Wordpress
     * 
     * @return void
     */
    public function create()
    {
        global $wpdb;

        foreach($this->tables as $table_name => $class) {
            call_user_func([$class, '__invoke'], $wpdb->prefix . $table_name);
        }
        
        add_option( 'pi_db_version', '1.0.0');
    }
}