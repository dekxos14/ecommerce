<?php

namespace src;

use Slim\Container;

function load($file): Container
{
    $file = path() . $file;

    if (!file_exists($file)) {
        throw new \Exception("Este aqruivo não existe: {$file}.");
    }

    $container = new Container($file);
    return $container;
}