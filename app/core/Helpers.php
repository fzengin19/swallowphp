<?php

use App\Core\Database;
use App\Exceptions\ViewNotFoundException;

/**
 * Returns the body of this object.
 *
 * @return string The body of this object.
 */
function view($view, $data = [])
{
    $viewPath = str_replace('.', '/', $view);
    $viewFile = ROOT_DIRECTORY . '/app/views/' . $viewPath . '.php';
    if (!file_exists($viewFile)) {
        throw new ViewNotFoundException();
    }
    foreach ($data as $key => $value) {
        ${$key} = $value;
    }
    ob_start();
    require $viewFile;
    $html = ob_get_clean();
    ob_end_clean();
    echo $html;

}

/**
 * Sends a redirect header to the client with the specified URI and HTTP status code.
 *
 * @param string $uri The URI to redirect to.
 * @param int $code The HTTP status code to send with the redirect.
 * @return void
 */
function redirect($uri, $code)
{
    header('Location: ' . $uri, true, $code);
}

/**
 * Sends the provided data to the output buffer and terminates the script.
 *
 * @param mixed $data The data to be sent to the output buffer.
 * @return void
 */
function send($data)
{
    print_r($data);
    die;
}


/**
 * Creates and returns a new instance of the Database class.
 *
 * @return Database A new instance of the Database class.
 */
function db()
{
    return new Database();
}



/**
 * Sends the given data as JSON response and terminates the script execution.
 *
 * @param mixed $data The data to be sent as JSON.
 * @throws No exceptions are thrown by this function.
 * @return void This function does not return any value.
 */
function sendJson($data)
{
    header('Content-Type: application/json');
    print_r(json_encode($data,JSON_UNESCAPED_UNICODE));
    die;
}

/**
 * Returns the IP address of the client making the request.
 *
 * @return string The IP address of the client as a string.
 */
function getIp()
{

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {

        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);

        return trim($ips[0]);
    }
    
    return $_SERVER['REMOTE_ADDR'];
}
