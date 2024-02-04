<?php

spl_autoload_register(function ($className) {
    // Define the base directory for your classes
    $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;

    // Normalize the class name (replace namespace separators with directory separators)
    $classFile = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    // Check if the class file exists and include it
    if (file_exists($classFile)) {
        require $classFile;
    }
});
