<?php
spl_autoload_register(function ($class) {
    $paths = ["/models/"]; 
    foreach ($paths as $file) {
        $file = __DIR__ . $file . $class . ".php";
        if (file_exists($file)) {
            require_once $file;
        }
    }
});