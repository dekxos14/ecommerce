<?php

function dieDump($data)
{
    var_dump($data);
    die();
}

function json($data)
{
    echo json_encode($data);
    die();
}