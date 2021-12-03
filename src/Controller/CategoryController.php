<?php
// src/Controller/CategoryController.php
namespace App\Controller;



use App\Entity\Program;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/category",  name="category_")
 */


class CategoryController extends AbstractController
{
    /** 
    * @Route("/", name="index")
    * @return Response A response instance

    */

   public function index()
   {
       $categorys = $this->getDoctrine()
           ->getRepository(Category::class)
           ->findAll();

       return $this->render('category/index.html.twig', [

           'categorys' => $categorys,

       ]);
   }



   /** 

    * @Route("/{categoryName}", methods={"GET"}, name="show")
    * @return Response 

    */

   public function show(string $categoryName)
   {

       $category = $this->getDoctrine()
           ->getRepository(Category::class)
           ->findOneBy(['name' => $categoryName]);


       $programs = $this->getDoctrine()
           ->getRepository(Program::class)
           ->findBy(['category' => $category], ['id' => 'desc'], 3);

       if (!$programs) {
           throw $this->createNotFoundException(
               'Aucune série trouvée.'
           );
       }

       return $this->render('category/show.html.twig', [

           'programs' => $programs,

       ]);
   }
}
