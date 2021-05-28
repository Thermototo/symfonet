<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @IsGranted("ROLE_USER")
 */

class ProfilController extends AbstractController
{
    /**
     * @Route("/profil", name="profil")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('profil/index.html.twig', [
            'users' => $users
        ]);
    }


    /**
     * @Route("/profil/{id}", name="profil_show")
     */
    public function show($id) : Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        return $this->render('profil/show.html.twig',[
            'user' => $user
        ]);
    }
}
