<?php

class productimp_ProductImporter {

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
     * Setup function only ran once on plugin activation
     */
    public function setup()
    {
        var_dump("HIER");
        die;
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
}