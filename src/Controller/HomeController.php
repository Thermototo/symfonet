<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $posts = $this->getDoctrine()->getRepository(Post::class)->findBy(   // findBy decroissant
            //on passe un tableau de critere (voir la signature)
            [],
            [
                'publishedAt' => 'DESC'
            ],
            10  // on limite a 10
        );
        // on recupere le formulaire pour les posts (PostType:  par convention Type = form)
        $form = $this->createForm(PostType::class, null, [
            'action' => $this->generateUrl('post_publish'),
        ]);

        

        return $this->render('home/index.html.twig', [
            'posts' => $posts,
            'post_publish_form' => $form->createView()
        ]);
    }
}
