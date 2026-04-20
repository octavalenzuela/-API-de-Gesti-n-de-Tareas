#!/usr/bin/env php
<?php

declare(strict_types=1);

/**
 * Script para crear el esquema de base de datos a partir de las entidades Doctrine.
 *
 * Uso:
 *   php bin/create-schema.php
 */

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

$container = require 'config/container.php';

$em     = $container->get(\Doctrine\ORM\EntityManagerInterface::class);
$tool   = new \Doctrine\ORM\Tools\SchemaTool($em);
$metas  = $em->getMetadataFactory()->getAllMetadata();

echo "Creando esquema de base de datos...\n";
$tool->createSchema($metas);
echo "Esquema creado correctamente.\n";
