<?php

use Core\Kernel;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/vendor/autoload.php';

$kernel = new Kernel();

$request = Request::createFromGlobals();
try {
    $response = $kernel->handle($request);
} catch (ORMException $e) {
}

$response->send();

?>