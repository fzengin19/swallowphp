<?php

namespace App\Core;

use Exception;
use App\Exceptions\MethodNotFoundException;
use App\Http\Middlewares\BaseMiddleware;

class Route
{
  private $method;
  private $uri;
  private $middleware = [];
  private $action;
  private static Request $request;


  /**
   * Constructs a new instance of the class.
   *
   * @param string $method The HTTP method to be used.
   * @param string $uri The URI to be used for the request.
   * @param mixed $action The action to be executed.
   * @param array $middleware An array of middleware functions to be executed.
   */
  public function __construct($method, $uri, $action, $middleware = [])
  {
    $this->uri = $uri;
    $this->method = $method;
    $this->action = $action;
    $this->middleware = $middleware;
  }

  /**
   * Adds a middleware to the collection of middlewares.
   *
   * @param mixed $middleware The middleware to add.
   * @return $this
   */
  public function middleware(BaseMiddleware $middleware)
  {
    $this->middleware[] = $middleware;
    return $this;
  }

  /**
   * Match the given request method and URI with this route.
   *
   * @param string $requestMethod The HTTP request method.
   * @param string $requestUri The HTTP request URI.
   * @return array|boolean Returns an array of route parameters if the route matches, 
   *              or false if there is no match.
   */
  public function match($requestMethod, $requestUri)
  {
    if ($this->method !== $requestMethod) {
      return false;
    }

    $routeUriParts = explode('/', $this->uri);
    $requestUriParts = explode('/', $requestUri);

    if (count($routeUriParts) !== count($requestUriParts)) {
      return false;
    }

    $params = [];

    for ($i = 0; $i < count($routeUriParts); $i++) {
      if (strpos($routeUriParts[$i], '{') !== false) {
        $paramName = trim($routeUriParts[$i], '{}');
        $paramValue = $requestUriParts[$i];
        $params[$paramName] = $paramValue;
      } elseif ($routeUriParts[$i] !== $requestUriParts[$i]) {
        return false;
      }
    }

    return $params;
  }

  /**
   * Executes the current action, after applying any middleware that has been set up.
   *
   * @param mixed ...$parameters The parameters to pass to the action.
   *
   * @throws Exception If there is an internal server error.
   * @throws MethodNotFoundException If the method is not found in the controller.
   */
  public function execute($request)
  {
    self::$request = $request;
    if (isset($this->middleware)) {
      $middlewares = $this->middleware;

      foreach ($middlewares as $middleware) {
        $middlewareInstance = new $middleware;
        if ($middlewareInstance instanceof BaseMiddleware) {
          $middlewareInstance->handle($request);
        }
      }
    }
    if (is_string($this->action)) {
      $action = explode('@', $this->action);
      $controller = "\App\\Http\\Controllers\\" . $action[0];
      $method = $action[1];

      if (class_exists($controller)) {
        if (method_exists($controller, $method)) {
          $controllerInstance = new $controller;
          print_r(call_user_func_array([$controllerInstance, $method], ['request' => $request]));
        } else {
          throw new MethodNotFoundException("'$method' Method Not Found", 404);
        }
      } else {
        throw new Exception("Controller '$controller' not found", 500);
      }
    } elseif (is_callable($this->action)) {
      print_r(call_user_func_array($this->action, ['request' => $request]));
    } else {
      throw new Exception('Internal Server Error', 500);
    }
  }


  /**
   * Returns the current value of the method property.
   *
   * @return mixed The current value of the method property.
   */
  public function getMethod()
  {
    return $this->method;
  }

  /**
   * Returns the current value of the method property.
   *
   * @return mixed The current value of the method property.
   */
  public function getUri()
  {
    return $this->uri;
  }
}
