<?php

// bootstrap.php
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once __DIR__."/../vendor/autoload.php";

// Create a simple "default" Doctrine ORM configuration for Annotations
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entity/"), $isDevMode);
// or if you prefer yaml or XML
//$config = Setup::createXMLMetadataConfiguration(array(__DIR__."/config/xml"), $isDevMode);
//$config = Setup::createYAMLMetadataConfiguration(array(__DIR__."/config/yaml"), $isDevMode);

// database configuration parameters
$conn = array(
    'driver' => 'pdo_sqlite',
    'path' => __DIR__ . '/../data/database.sqlite',
);

// obtaining the entity manager
try {
    $entityManager = EntityManager::create($conn, $config);
} catch (ORMException $e) {
}
return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);