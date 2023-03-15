<?php
namespace ProductImp\Routing;

class Router {
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
      return true;
      // User needs to be logged in to use the Custom Rest API of ProductImp
      return is_user_logged_in();
    }
}