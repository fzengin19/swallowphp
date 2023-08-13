<?php

namespace Config;

require_once 'Constants.php';
require_once ROOT_DIRECTORY . '/app/core/Helpers.php';

use App\Core\Env;
use App\Core\ExceptionHandler;
use App\Core\Request;
use App\Core\Router;
use App\Core\RateLimiter;


class Application
{
    private static $instance;
    private static Router $router;


    /**
     * Initializes a new instance of the class and creates a new Router object.
     */
    private function __construct()
    {
        self::$router = new Router();
    }

    /**
     * Returns a single instance of this class.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Returns the router instance.
     *
     * @return Router The router instance.
     */
    public static function getRouter()
    {
        return self::$router;
    }

    /**
     * Sets the router object to be used by the class.
     *
     * @param Router $router The router object to be used.
     * @return void
     */
    public static function setRouter(Router $router)
    {
        self::$router = $router;
    }

    /**
     * Handles a request by dispatching it to the router.
     *
     * @param Request $request The request object to handle.
     *
     * @return void
     */
    public static function handleRequest(Request $request)
    {
        self::$router::dispatch($request);
    }

    /**
     * Executes the main application logic by loading the environment, rate limiting the
     * request, and handling the incoming request.
     *
     * @return void
     *
     * @throws Throwable If an error occurs during execution.
     */
    public static function run()
    {
        try {
            Env::load();
            RateLimiter::execute();
            $request = Request::createFromGlobals();
            mb_internal_encoding('UTF-8');
            self::handleRequest($request);
        } catch (\Throwable $th) {
            ExceptionHandler::handle($th);
        }
    }
}
