<?php

namespace src;

use Slim\Container;

function slimConfiguration(): Container
{
    $configuration = [
        'settings' => [
            'displayErrorDetails' => getenv('DISPLAY_ERROS_DETAILS'),
        ],
    ];
    $container = new Container($configuration);

    return $container;
}