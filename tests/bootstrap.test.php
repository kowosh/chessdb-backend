<?php

require_once __DIR__.'/../vendor/autoload.php';

if (isset($_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])) {
    // run symfony commands (very bootstrapped, @todo move this out
    $commands = [
        'doctrine:database:drop --force',
        'doctrine:database:create',
        'doctrine:schema:create',
    ];

    foreach ($commands as $command) {
        passthru(
            sprintf('php "%s/../bin/console" %s -n --env=%s', __DIR__, $command, $_ENV['BOOTSTRAP_CLEAR_CACHE_ENV'])
        );
    }
}
