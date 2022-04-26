<?php

class lmwcwppi_Routing_Router {
    private $routesFile = 'Config/routes.json';

    public function get_routes()
    {
        return json_decode(file_get_contents($this->routesFile, true), true);
    }

    public function add_route($route)
    {
        register_rest_route(
            'ntwcwppi/v1',
            $route['route'],
            [
              'methods' => $route['methods'],
              'callback' => [new $route['class'], $route['callback']]
            ]
          );
    }
}