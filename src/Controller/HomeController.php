<?php  

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/home")
 */
class HomeController extends AbstractController
{


     /**
     * @Route("/", name="home_index", methods={"GET"})
     */
  public function index()
    {
      
    return $this->render('home.html.twig');
    }
    
     
}