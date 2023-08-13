<?php

// spl_autoload_register(function ($class) {
//     $prefix = '\';
//     $base_dir = strtolower( realpath(__DIR__ . '/..'));
//     // print_r($base_dir);
//     $len = strlen($prefix);   
//     if (strncmp($prefix, $class, $len) !== 0) {
//         return;
//     }
//     $relative_class = substr($class, $len);
//     $file = $base_dir . '/' . str_replace('\\', '/', $relative_class) . '.php';
//     $file= strtolower($file);
//     if (file_exists($file)) {
//         require_once $file;
//     }
// });