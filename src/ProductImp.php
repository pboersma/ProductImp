<?php
namespace ProductImp;

use ProductImp\Routing\Router;
use ProductImp\Database\Setup;

class ProductImp {
    /**
     * The plugin router.
     *
     * @var Router
     */
    private $router;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Loads the plugin into WordPress.
     * 
     * @return void
     */
    public function load()
    {
        wp_create_nonce('wc_authentication_nonce');
        
        // Initialize Rest API Routes
        add_action('rest_api_init', function () {
            foreach ($this->router->get_routes() as $route) {
                $this->router->add_route($route);
            }
        });

        // Initialize MenuItem + View.
        add_action('admin_menu', array($this, 'addMenu'));
    }

    /**
     * Setup the ProductImp Database requirements.
     * 
     * @return void
     */
    public function setup()
    {
        $database = new Setup();
        $database->create();
    }

    /**
     * Add the ProductImp to Wordpress.
     * 
     * @return void
     */
    public function addMenu()
    {
        add_menu_page(
            'productimp', 
            'ProductImp', 
            'edit_posts', 
            'productimp_product_import', 
            function(){
                echo "<div id='app'></div>";
                wp_enqueue_script('productimp_app-vue', plugin_dir_url( __FILE__ ) . 'dist/assets/index-2711257b.js', [], '1.0', true);
                wp_enqueue_style('productimp_app-styling', plugin_dir_url( __FILE__ ) . 'dist/assets/index-8c1ace62.css', [], '1.0', 'all');
                wp_enqueue_style('productimp_font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css', [], '1.0', 'all');
                wp_localize_script('productimp_app-vue', 'ProductImp', [
                    'root' => esc_url_raw( rest_url() ),
                    'nonce' => wp_create_nonce('wp_rest'),
                ]);
            }, 
            'dashicons-products'
        );
    }
}