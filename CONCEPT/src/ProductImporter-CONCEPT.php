<?php
namespace ProductImp;

class productimp_ProductImporter
{
    /**
     * The plugin router.
     *
     * @var productimp_Routing_Router
     */
    private $router;

    /**
     * The view maker.
     *
     * @var productimp_Visualization_Viewmaker
     */
    private $viewMaker;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->router = new productimp_Routing_Router();
        $this->viewMaker = new productimp_Visualization_Viewmaker();
    }

    /**
     * Setup function only ran once on plugin activation.
     */
    public function setup()
    {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $datasource_table = "CREATE TABLE wp_pi_datasources (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            datasource_name varchar(255) NOT NULL,
            datasource_url varchar(255) NOT NULL,
            datasource_credentials varchar(1000) DEFAULT '{}' NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            PRIMARY KEY  (id)
        ) $charset_collate;";

        $products_table = "CREATE TABLE wp_pi_products (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            datasource_id varchar(255) NOT NULL,
            ean varchar(255),
            product varchar(15000) DEFAULT '{}' NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            UNIQUE (ean),
            PRIMARY KEY  (id)
        ) $charset_collate";

        $products_map_table = "CREATE TABLE wp_pi_products_map (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id varchar(255) NOT NULL,
            map varchar(15000) DEFAULT '{}' NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            UNIQUE (product_id),
            PRIMARY KEY  (id)
        ) $charset_collate";

        $products_woocommerce_table = "CREATE TABLE wp_pi_products_woocommerce (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            product_id varchar(255) NOT NULL,
            woocommerce_product_id varchar(255) NOT NULL,
            created_on timestamp DEFAULT NOW() NULL,
            PRIMARY KEY  (id)
        ) $charset_collate";

        $this->createTable('pi_datasources', $datasource_table);
        $this->createTable('pi_products', $products_table);
        $this->createTable('pi_products_map', $products_map_table);
        $this->createTable('pi_products_woocommerce', $products_woocommerce_table);
    }

    public function deactivate()
    {
        delete_option("productimp_rest");
    }

    /**
     * Loads the plugin into WordPress.
     */
    public function load()
    {
        // Initialize Rest API Routes
        add_action('rest_api_init', function () {
            foreach ($this->get_routes() as $route) {
                $this->router->add_route($route);
            }
        });

        // Initialize MenuItem + View.
        add_action('admin_menu', array($this->viewMaker, 'addMenuItem'));
    }

    /**
     * Returns the plugin routes.
     *
     * @return array
     */
    private function get_routes()
    {
        return $this->router->get_routes();
    }

    private function createTable($table_name, $schema)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . $table_name;
        $charset_collate = $wpdb->get_charset_collate();
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $schema );
        add_option( 'pi_db_version', '1.0.0');
    }
}
