<?php

namespace App\Controllers;

use App\Models\Person;
use App\Models\User;

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
}