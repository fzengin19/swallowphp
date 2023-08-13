<?php

namespace App\Core;

use App\Core\Route;
use App\Exceptions\MethodNotAllowedException;
use App\Exceptions\RouteNotFoundException;

class Router
{

    /**
     * Route collection for storing registered routes.
     *
     * This collection holds all registered routes in the application.
     * It is used to store and retrieve route information for routing purposes.
     *
     * @var Route[]
     */
    protected static $routes = [];


    /**
     * Creates and returns a new Route object for a GET request with the given URI and action.
     * 
     * @param string $uri The URI pattern for the route.
     * @param string $action The action to be taken when the route is matched.
     * @return Route The newly created Route object.
     */
    public static function get($uri, $action)
    {
        $route = new Route("GET", $uri, $action);
        array_push(self::$routes, $route);
        return $route;
    }

    /**
     * Creates a new POST route with the given URI and action function, and adds it to the list of routes.
     *
     * @param string $uri The URI pattern for the route.
     * @param callable|string $action The action function to call when the route is matched.
     * @return Route The newly created route.
     */
    public static function post($uri, $action)
    {
        $route = new Route("POST", $uri, $action);
        array_push(self::$routes, $route);
        return $route;
    }

    /**
     * Returns the routes stored in the class variable $routes.
     *
     * @return array An array of routes.
     */
    public function getRoutes()
    {
        return self::$routes;
    }

    /**
     * Dispatches the given request to the appropriate route based on the request's method and URI.
     *
     * @param Request $request The request object to dispatch.
     * @return mixed The result of the executed route.
     * @throws RouteNotFoundException If no route is found for the given request.
     */
    public static function dispatch(Request $request)
    {
        $requestUri = parse_url($request->getUri(), PHP_URL_PATH);

        foreach (self::$routes as $route) {
            $routeUri = preg_quote($route->getUri(), '/');
            $pattern = '/^' . str_replace(['\{', '\}'], ['(?P<', '>[^\/]+)'], $routeUri) . '$/';

            if (preg_match($pattern, $requestUri, $matches)) {
                if ($route->getMethod() === $request->getMethod()) {

                    $params = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);
                    $request->setAll(array_merge($params, $request->all()));
                    return $route->execute($request);
                }
                throw new MethodNotAllowedException('Method Not Allowed for ' . $requestUri.' Supported Method: ' . $route->getMethod());
            }
        }

        throw new RouteNotFoundException();
    }
}
