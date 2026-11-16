<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route("/products", name: "app_product_index")]
    public function index(): Response
    {
        return $this->render("product/index.html.twig", [
            "controller_name" => "ProductController",
        ]);
    }

    #[Route("/product/{slug}", name: "app_product_show")]
    public function show(string $slug): Response
    {
        return $this->render("product/index.html.twig", [
            "controller_name" => "ProductController",
            "slug" => $slug,
        ]);
    }
}
