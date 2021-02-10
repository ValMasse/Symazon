<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/products", name="product_index", methods={"GET"})
     * @param ProductRepository $productRepository
     * @return Response
     */
    public function index(ProductRepository $productRepository) : Response
    {
        $products = $productRepository->findAll();

        //$products = $productRepository->findByQuantityNotNull();


        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }


    /**
     * @Route("/products/new", name="product_create", methods={"GET","POST"})
     */
    public function create(Request $request) : Response
    {
        $product = new Product;
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);

        // $product->setTitle( $request->request->get('title') );
        // $product->setDescription( $request->request->get('description') );
        // $product->setPrice( $request->request->get('price') );
        // $product->setQuantity( $request->request->get('quantity') );

        // $manager = $this->getDoctrine()->getManager();

        // $manager->persist($product);
        // $manager->flush();

        // return $this->redirectToRoute("product_index");
    }

    /**
     * @Route("/products/{id}", name="product_show", requirements={"page"="\d+"})
     */
    public function findProductById(ProductRepository $productRepository, $id) : Response
    {
        $product = $productRepository->find($id);

        //dd($product);

        return $this->render('product/showItem.html.twig', [
            'product' => $product
        ]);
    }

    /**
     * @Route("/products/{product}/edit", name="product_edit", methods={"GET"})
     * @param Product $product
     * @return Response
     */
    public function edit(Product $product) : Response
    {
        return  $this->render('product/new.html.twig', ['product' => $product]);
    }

    /**
     * @Route("/products/{product}/edit", name="product_update", methods={"POST"})
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function update(Request $request, Product $product) : Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/products/{product}/delete", name="product_delete", methods={"POST"})
     * @param Product $product
     * @return Response
     */
    public function delete(Product $product) : Response
    {
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($product);
        $manager->flush();

        return $this->redirectToRoute('product_index');
    }



    
}
