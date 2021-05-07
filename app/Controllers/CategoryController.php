<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductCategory;

use Respect\Validation\Validator as v;

class CategoryController extends Controller
{
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


    public function getProductCategory($request, $response, $args)
    {
        $category = Category::where('idcategory', '=', $args['id'])->first();
        $products = Product::with('category')->get();

        $data = [
            'category' => $category,
            'products' => $products
        ];

        return $this->container->view->render($response, 'admin/categories-products.twig', $data);
    }

}