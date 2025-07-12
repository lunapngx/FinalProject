<?php

// Include Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Try to access the class
$className = 'CodeIgniter\\Shield\\Database\\Seeds\\AuthSeeder';

if (class_exists($className)) {
    echo "SUCCESS: Class '{$className}' found!\n";
    try {
        new $className();
        echo "SUCCESS: Class instantiated!\n";
    } catch (Throwable $e) {
        echo "ERROR: Could not instantiate class: " . $e->getMessage() . "\n";
    }
} else {
    echo "FAILURE: Class '{$className}' NOT found.\n";
    echo "Autoloading might be broken or the class path is incorrect.\n";
}