<?php

namespace App\Controllers;

use App\Models\{
    Category,
    Product
};


class HomeController extends Controller
{
    public function home($request, $response)
    {
        $categories = Category::all();
        $products = Product::all();

        $data = [
            'categories' => $categories,
            'products' => $products,
        ];

        return $this->container->view->render($response, 'site/home.twig', $data);
    }

    public function getCategoryProducts($request, $response)
    {
        $category = Category::find($request->getParam('id'));
        $products = Product::find($request->getParam('id'));

        $data = [
            'category' => $category,
            'products' => $products,
        ];

        return $this->container->view->render($response, 'site/category.twig', $data);
    }


    public function getProductDetail($request, $response)
    {
        $product = Product::find($request->getParam('id'));

        $data = [
            'product' => $product,
        ];

        return $this->container->view->render($response, 'site/product-detail.twig', $data);
    }

}
