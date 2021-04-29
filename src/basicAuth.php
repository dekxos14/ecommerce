<?php

namespace src;

use Tuupola\Middleware\HttpBasicAuthentication;
use App\Models\User;
use App\Controllers\LoginController;
use Psr\Http\Message\UriInterface;
use \Psr\Http\Message\ResponseInterface as Response;

function basicAuth(): HttpBasicAuthentication
{
    $load = new LoginController();

    return new HttpBasicAuthentication([
        // fazer um array para pegar todos os usuarios do DB
        "users" => [
            "Jane" => "987654321"
//            $user->getLogin() => $user->getPassword()
        ],
        "after" => function (Response $reponse) {
            $reponse = LoginController::class . 'loginTemplate';
            return $reponse;
        }
    ]);
}