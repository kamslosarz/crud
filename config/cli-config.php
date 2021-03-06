<?php

// bootstrap.php
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__."/../vendor/autoload.php";


$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__ . "/../src/Entity"), true);
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../data/database.sqlite',
);

try {
    $entityManager = EntityManager::create($conn, $config);
} catch (ORMException $e) {

}

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);