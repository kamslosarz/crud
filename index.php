<?php

use Core\Kernel;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($name) {
    $file = sprintf('%s.php', str_replace('\\', '/', $name));
    if (file_exists($file)) {
        require sprintf('%s.php', str_replace('\\', '/', $name));
    } else {
        $file = sprintf('src/%s.php', str_replace('\\', '/', $name));
        if (file_exists($file)) {
            require sprintf('%s.php', str_replace('\\', '/', $name));
        }
    }
});

$kernel = new Kernel();

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);


?>