<?php

class productimp_Routing_Router {
    private $routesFile = 'Config/routes.json';

    public function get_routes()
    {
        return json_decode(file_get_contents($this->routesFile, true), true);
    }

    public function add_route($route)
    {
        register_rest_route(
            'productimp/v1',
            $route['route'],
            [
              'methods' => $route['methods'],
              'callback' => [new $route['class'], $route['callback']],
              'permission_callback' => [$this, 'authenticate']
            ]
          );
    }

    public function authenticate()
    {
      // TODO: Write rest-api authentication. Examples: https://cdn2.hubspot.net/hubfs/298401/Documents_for_download/WP-API-ebook_final_09162015.pdf
      return true;
    }
}