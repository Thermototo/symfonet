<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;  
/* namespace pour @isgaranted */ 
/* @IsGgranted dit qu'il faut etre logger au minimum en user pour acceder a home */

/**
 * @IsGranted("ROLE_USER")
 */

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        /* on recupere tous les posts dans le home  */
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();

        

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            
        ]);
    }
}
