<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMSetup;
use Psr\Container\ContainerInterface;

/**
 * Factory que construye el EntityManager de Doctrine a partir de la configuración.
 */
class EntityManagerFactory
{
    public function __invoke(ContainerInterface $container): EntityManagerInterface
    {
        $config  = $container->get('config');
        $doctrineConfig = $config['doctrine'];

        $ormConfig = ORMSetup::createAttributeMetadataConfiguration(
            paths: $doctrineConfig['entity_paths'],
            isDevMode: $doctrineConfig['dev_mode'] ?? true,
        );

        return EntityManager::create($doctrineConfig['connection'], $ormConfig);
    }
}
