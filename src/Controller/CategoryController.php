<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController{

/**
 * @Route("/index", name="category_index", methods={"GET"})
 */
public function index(CategoryRepository $categoryRepository){
    
    $categories = $categoryRepository->findAll();

    //dd($categories);

    return $this->render('category/index.html.twig', [
        'categories' => $categories    
    ]);
}


/**
 * @Route("/new", name="category_new", methods={"GET","POST"})
 */
public function new(Request $request) : Response
{    
// CAS GET (affichage) :
    // On prépare l'article à créer avec le formulaire
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);

// CAS POST (traitement) :
    // On indique au formulaire de traiter la requête
    $form->handleRequest($request);

    // Si le formulaire a été envoyé et est valide, on le traite
    if($form->isSubmitted() && $form->isValid()){
                   
        // On enregistre la donnée
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($category);
        $entityManager->flush();

        // On redirige vers la page article_index
        return $this->redirectToRoute('category_index');
    }

    // CAS GET ou CAS POST SI FORMULAIRE INVALIDE (if ci-dessus) :
    // On affiche le formulaire
    return $this->render('category/new.html.twig', [
        'category' => $category,
        'form' => $form->createView(),
    ]);
}




}


?>