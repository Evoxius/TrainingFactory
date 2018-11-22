<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CookiesController extends AbstractController
{
    /**
     * @Route("/cookies", name="cookies")
     */
    public function index()
    {
        return $this->render('cookies/index.html.twig', [
            'controller_name' => 'CookiesController',
        ]);
    }
}
