<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/post", name="post")
     */
    public function index(): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
        ]);
    }



    /**
     * @Route("/post/publish", name="post_publish")
     */
    public function publish(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);  

        // si submit et verifie
        if($form->isSubmitted() && $form->isValid())
        {
            // on passe les infos de la date et de l'uitilisateur
            $post
                ->setPublishedAt(new \DateTime())
                ->setUser($this->getUser());


            // on met en base de donnée   
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($post);
            $manager->flush();
        }

        return $this-> redirectToRoute('home');
    }
}
