<?php

namespace App\Controllers;

use App\Models\User;
use App\Auth;
use Respect\Validation\Validator as v;

class AuthController extends Controller
{
    public function login($request, $response)
    {
        if($request->isGet())
            return $this->container->view->render($response, 'admin/login.twig');


        if(!$this->container->auth->attempt(
            $request->getParam('login'),
            $request->getParam('password'))) {
            return $response->withRedirect($this->container->router->pathFor('auth.login'));
        }

        return $response->withRedirect($this->container->router->pathFor('admin'));
    }
}
