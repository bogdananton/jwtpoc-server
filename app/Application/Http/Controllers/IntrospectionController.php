<?php
namespace JWTPOC\Application\Http\Controllers;

use Illuminate\Routing\Controller;
use MultiRouting\Route;

class IntrospectionController extends Controller
{
    public function get()
    {
        $links = [];
        $routes = $this->getRouter()->getRoutes();

        /** @var Route $route */
        foreach ($routes as $route) {
            $routeUri = $route->getUri();
            $routeParts = explode('/', $routeUri);

            if ($routeParts[0] == 'api' && count($routeParts) > 1) {
                $part = $routeParts[1];
                $url = ACTUAL_API_URL . '/' . $part;
                
                if (!in_array($url, $links)) {
                    $links[$part . '_link'] = $url;
                }
            }
        }

        return $links;
    }
}
