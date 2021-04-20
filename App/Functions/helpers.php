<?php

function dieDump($data)
{
    echo '<pre>';
    var_dump($data);
    die();
}

function json($data)
{
    echo json_encode($data);
    die();
}

/**
 * Pega a raiz do projeto
 * @return string
 */
function path(): string
{
    $vendorDir = dirname(dirname(__FILE__));
    return dirname($vendorDir);
}
