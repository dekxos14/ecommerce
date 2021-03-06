<?php

namespace App\Controllers;

use App\Models\Person;

use Respect\Validation\Validator as v;

class PageAdminController extends Controller
{
    public function index($request, $response)
    {
        return $this->container->view->render($response, 'admin/main.twig');
    }


    public function getUsers($request, $response)
    {
        $user_persons = Person::with('user')->get();

        $data = [
            'user_persons' => $user_persons,
        ];

        return $this->container->view->render($response, 'admin/users.twig', $data);
    }


    public function createUser($request, $response)
    {
        if($request->isGet())
            return $this->container->view->render($response, 'admin/users-create.twig');

        $validation = $this->container->validator->validate($request,[
            'desperson' =>  v::notEmpty()->alpha()->length(5),
            'deslogin' =>  v::notEmpty()->noWhitespace(),
            'nrphone' => v::notEmpty()->noWhitespace()->regex("/^\(\d{2}\)\d{4}-\d{4}$/"),
            'desemail' => v::notEmpty()->noWhitespace()->email(),
            'despassword' => v::notEmpty()->noWhitespace()
        ]);

        if($validation->failed())
            $response->withRedirect($this->container->router->pathFor('admin.create'));


        Person::create([
            'desperson' => $request->getParam('desperson'),
            'desemail' => $request->getParam('desemail'),
            'nrphone' => $request->getParam('nrphone')
        ])
            ->user()
            ->create([
                'deslogin' => $request->getParam('deslogin'),
                'despassword' => password_hash($request->getParam('despassword'), PASSWORD_DEFAULT),
                'inadmin' => $request->getParam('inadmin') == '0' ? false : true
            ]);

        return $response->withRedirect($this->container->router->pathFor('auth.login'));
    }


    public function updateUser($request, $response, $args)
    {
        $user_persons = Person::with('user')->where('idperson', '=', $args['id'])->first();

        $data = [
            'person' => $user_persons
        ];

        if($request->isGet())
            return $this->container->view->render($response, 'admin/users-update.twig', $data);

        $validation = $this->container->validator->validate($request,[
            'desperson' =>  v::notEmpty()->alpha()->length(5),
            'deslogin' =>  v::notEmpty()->noWhitespace(),
            'nrphone' => v::notEmpty()->noWhitespace()->regex("/^\(\d{2}\)\d{4}-\d{4}$/"), //
            'desemail' => v::notEmpty()->noWhitespace()->email(),
        ]);

        if($validation->failed())
            $response->withRedirect($this->container->router->pathFor('admin.edit', ['id' => $user_persons->idperson]));


        $user_persons->update([
            'desperson' => $request->getParam('desperson'),
            'nrphone' => $request->getParam('nrphone'),
            'desemail' => $request->getParam('desemail'),
        ]);

        $user_persons->user()->update([
            'deslogin' => $request->getParam('deslogin'),
            'inadmin' => $request->getParam('inadmin')
        ]);

        $this->container->flash->addMessage('success', 'Usu??rio atualizado com sucesso!');

        return $response
            ->withRedirect($this->container->router->pathFor('admin.users'));
    }


    public function deleteUser($request, $response)
    {
        $person = Person::with('user')->find($request->getParam('id'));

        if ($person) {
            $person->delete();
            $this->container->flash->addMessage('success', 'Usu??rio deletado.');
        } else {
            $this->container->flash->addMessage('error', 'Post n??o pode ser deletado.');
        }

        return $response->withRedirect($this->container->router->pathFor('admin.users'));
    }
}