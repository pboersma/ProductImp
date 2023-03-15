<?php
namespace ProductImp;

use ProductImp\Routing\Router;

class ProductImp {
    /**
     * The plugin router.
     *
     * @var Router
     */
    private $router;

    /**
     * The view maker.
     *
     * @var productimp_Visualization_Viewmaker
     */
    private $viewMaker;

    public function __construct()
    {
        $this->router = new Router();
    }

    /**
     * Loads the plugin into WordPress.
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

        // // Initialize MenuItem + View.
        // add_action('admin_menu', array($this->viewMaker, 'addMenuItem'));
    }
}