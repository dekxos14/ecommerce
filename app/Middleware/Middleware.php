<?php

namespace App\Middleware;

class Middleware
{
    protected $container;

    /**
     * Middleware constructor (Father).
     */
    public function __construct($container)
    {
        $this->container = $container;
    }
}