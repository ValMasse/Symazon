<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AppController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository) : Response
    {
        return $this->render('app/index.html.twig', [
            'products' => $productRepository->findAll()
        ]);
    }

    /**
     * @Route("/productsSearch", name="products_search", methods={"POST"})
     */
    public function searchAProduct(Request $request, ProductRepository $productRepository) : Response{
        $products = $productRepository->findBySearch($request->request->get('search'));
        //dd($products);
        return $this->render('product/productResearch.html.twig', [
            'products' => $products
        ]);
    }

}
