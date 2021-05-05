<?php

namespace App\Controllers;

use App\Models\Person;
use App\Models\Category;

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

//        $persons = Person::with('user')->where('idperson', '=', $args['id'])->first();
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

        $this->container->flash->addMessage('success', 'Usuário atualizado com sucesso!');

        return $response
            ->withRedirect($this->container->router->pathFor('admin.users'));
    }


    public function deleteUser($request, $response)
    {
        $person = Person::with('user')->find($request->getParam('id'));

        if ($person) {
            $person->delete();
            $this->container->flash->addMessage('success', 'Usuário deletado.');
        } else {
            $this->container->flash->addMessage('error', 'Post não pode ser deletado.');
        }

        return $response->withRedirect($this->container->router->pathFor('admin.users'));
    }







    /**
     * Pegar todas as categorias do DB.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function getCategories($request, $response)
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];

        return $this->container->view->render($response, 'admin/categories.twig', $data);
    }

    /**
     * Faz o load da página se for GET, e cria uma nova categoria.
     * @param $request
     * @param $response
     * @return mixed
     */
    public function createCategory($request, $response)
    {
        if($request->isGet())
            return $this->container->view->render($response, 'admin/categories-create.twig');

        $validation = $this->container->validator->validate($request,[
            'descategory' =>  v::notEmpty()->alpha()->length(2),
        ]);

        if($validation->failed())
            $response->withRedirect($this->container->router->pathFor('admin.category-create'));

        Category::create([
            'descategory' => $request->getParam('descategory'),
        ]);

        return $response->withRedirect($this->container->router->pathFor('admin.categories'));
    }


    public function updateCategory($request, $response, $args)
    {
        $category = Category::where('idcategory', '=', $args['id'])->first();

        $data = [
            'category' => $category
        ];

        if($request->isGet())
            return $this->container->view->render($response, 'admin/categories-update.twig', $data);

        $validation = $this->container->validator->validate($request,[
            'descategory' =>  v::notEmpty()->alpha()->length(2),
        ]);

        if($validation->failed())
            $response->withRedirect($this->container->router->pathFor('admin.category-update'));

        $category->update([
            'descategory' => $request->getParam('descategory'),
        ]);

        $this->container->flash->addMessage('success', 'Categoria atualizada com sucesso!');

        return $response->withRedirect($this->container->router->pathFor('admin.categories'));
    }


    public function deleteCategory($request, $response)
    {
        $category = Category::find($request->getParam('id'));

        if ($category) {
            $category->delete();
            $this->container->flash->addMessage('success', 'Categoria deletada.');
        } else {
            $this->container->flash->addMessage('error', 'Categoria não pode ser deletada.');
        }

        return $response->withRedirect($this->container->router->pathFor('admin.categories'));
    }
}