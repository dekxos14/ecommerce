<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController extends Controller
{
    public function home($request, $response)
    {
        $categories = Category::all();

        $data = [
            'categories' => $categories,
        ];

        return $this->container->view->render($response, 'site/home.twig', $data);
    }

    public function getCategory($request, $response)
    {
        $category = Category::find($request->getParam('id'));

        $data = [
            'category' => $category,
        ];

        return $this->container->view->render($response, 'site/category.twig', $data);
    }

}
