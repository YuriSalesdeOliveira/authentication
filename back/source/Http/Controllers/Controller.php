<?php

namespace Source\Http\Controllers;

use CoffeeCode\Router\Router;

class Controller
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
}