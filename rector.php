<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/web/app/plugins/cookie-banner-ggcom',
    ])
    // On force la version la plus haute dispo si PHP_90 n'existe pas encore
    ->withPhpVersion(80400) // 8.4 est le pont direct vers 9.0
    
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        earlyReturn: true
    );