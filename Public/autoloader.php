<?php

spl_autoload_register(function ($className) {
    /**
     * TITLE: SET PUBLISH MODE [true/false][Server/Localhost]
     * ~ Description: Set the publish mode to true or false
     * 
     * @var string $publish
     * @var string $baseDir
     * @var string $classFile
     */
    // ----------------------------------------
    $publish = "false";
    // ----------------------------------------

    // Check If Published Mode True/False
    if ($publish == "false") {
        $baseDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'Invoicing-System' . DIRECTORY_SEPARATOR; // Localhost Directory
    } else {
        $baseDir = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR; // Server Directory
    }

    // Normalize the class name (replace namespace separators with directory separators)
    $classFile = $baseDir . str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';

    // Check if the class file exists and include it
    if (file_exists($classFile)) {
        require $classFile;
    }
});
