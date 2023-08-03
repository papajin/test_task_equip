<?php

use Equip\Application;

Application::build(require __DIR__ . '/di.php')
           ->setConfiguration(require __DIR__ . '/config.php')
           ->setMiddleware(require __DIR__ . '/middleware.php')
           ->setRouting(\App\Routing::class)
           ->run();