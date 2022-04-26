<?php

class lmwcwppi_ProductImporter {

    /**
     * The plugin router.
     *
     * @var lmwcwppi_Routing_Router
     */
    private $router;

    /**
     * The view maker.
     *
     * @var lmwcwppi_Visualization_Viewmaker
     */
    private $viewMaker;

   /**
     * Constructor.
     */
    public function __construct()
    {
        $this->router = new lmwcwppi_Routing_Router();
        $this->viewMaker = new lmwcwppi_Visualization_Viewmaker();
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