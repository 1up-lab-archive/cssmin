<?php

if (!$loader = @include __DIR__.'/../vendor/autoload.php') {
    die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL);
}

spl_autoload_register(function($class) {
    if (0 === strpos($class, 'Oneup\\CssMin\\')) {
        $path = __DIR__.'/../src/Oneup/CssMin/'.implode('/', array_slice(explode('\\', $class), 2)).'.php';
        if (!stream_resolve_include_path($path)) {
            return false;
        }
        require_once $path;

        return true;
    }
});
