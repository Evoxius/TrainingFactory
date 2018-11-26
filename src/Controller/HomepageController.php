<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends AbstractController
{
    /**
     * @Route("/home", name="homepage")
     */
    public function index()
    {
        return $this->render('homepage/index.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/home/gratis-dagpas", name="gratis_dagpas")
     */
    public function dagpas()
    {
        return $this->render('homepage/dagpas.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }
}
