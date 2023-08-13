<?php

namespace App\Core;

class Env
{
    /**
     * Retrieves the value of an environment variable.
     *
     * @param string $key The name of the environment variable to retrieve.
     * @param mixed|null $default The default value to return if the variable is not set.
     *
     * @return mixed The value of the environment variable, or the default value if not set.
     */
    public static function get($key, $default = null)
    {
        $value = getenv($key);
        return $value !== false ? $value : $default;
    }

    /**
     * Loads environment variables from a file named ".env" located at the root directory.
     * 
     * If the file exists, it reads its contents line by line and sets each environment variable
     * by calling the putenv() function with the name-value pair in the form "name=value".
     * 
     * @return void
     */
    public static function load()
    {
        if (file_exists(ROOT_DIRECTORY . '/.env')) {
            $lines = file(ROOT_DIRECTORY . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                list($name, $value) = explode('=', $line, 2);
                putenv("$name=$value");
            }
        }
    }
}
