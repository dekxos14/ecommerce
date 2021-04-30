<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Person;
use Respect\Validation\Validator as v;

class PageAdminController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'admin/main.twig');
    }

    public function users($request, $response)
    {
        $users = User::all();
        $data = [
            'users' => $users,
        ];

        return $this->container->view->render($response, 'admin/users.twig', $data);
    }

    public function create($request, $response)
    {
        if($request->isGet())
            return $this->container->view->render($response, 'admin/users-create.twig');

        $validation = $this->container->validator->validate($request,[
            'desperson' =>  v::notEmpty()->alpha(),  // ->length(5)
            'deslogin' =>  v::notEmpty()->noWhitespace(),
            'nrphone' => v::notEmpty()->noWhitespace(), // ->regex("/^\(\d{2}\)\d{4}-\d{4}$/")
            'desemail' => v::notEmpty()->noWhitespace()->email(),
            'despassword' => v::notEmpty()->noWhitespace()
        ]);

        if($validation->failed())
            echo 'Error'; //$response->withRedirect($this->container->router->pathFor('admin.create'));


        User::create([
            'deslogin' => $request->getParam('deslogin'),
            'despassword' => password_hash($request->getParam('despassword'), PASSWORD_DEFAULT),
            'inadmin' => $request->getParam('inadmin')
        ]);

        Person::create([
            'desperson' => $request->getParam('desperson'),
            'desemail' => $request->getParam('desemail'),
            'nrphone' => $request->getParam('nrphone')
        ]);

        return $response->withRedirect($this->container->router->pathFor('auth.login'));
    }
}