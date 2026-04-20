<?php

declare(strict_types=1);

/**
 * Configuración de Doctrine ORM.
 * Los valores sensibles (usuario, contraseña) se sobreescriben en doctrine.local.php
 * que NO se sube al repositorio.
 */
return [
    'doctrine' => [
        'connection' => [
            'driver'   => 'pdo_sqlite',
            'path'     => __DIR__ . '/../../data/database.sqlite',
        ],
        'entity_paths' => [
            __DIR__ . '/../../src/App/Task/Entity',
        ],
        'dev_mode' => true,
    ],
];
