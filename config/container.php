<?php

declare(strict_types=1);

use Laminas\ConfigAggregator\ArrayProvider;
use Laminas\ConfigAggregator\ConfigAggregator;
use Laminas\ConfigAggregator\PhpFileProvider;
use Laminas\ServiceManager\ServiceManager;

$aggregator = new ConfigAggregator([
    \Mezzio\Helper\ConfigProvider::class,
    \Mezzio\Router\FastRouteRouter\ConfigProvider::class,
    \Mezzio\ConfigProvider::class,
    \Mezzio\Router\ConfigProvider::class,
    new PhpFileProvider('config/autoload/*.php'),
    new ArrayProvider(['config_cache_path' => 'data/cache/config-cache.php']),
]);

$config = $aggregator->getMergedConfig();

$container = new ServiceManager();
(new \Laminas\ServiceManager\Config($config['dependencies'] ?? []))->configureServiceManager($container);
$container->setService('config', $config);

return $container;
