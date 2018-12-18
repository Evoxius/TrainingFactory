<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LessenController extends AbstractController
{
    /**
     * @Route("/lessen", name="lessen")
     */
    public function index()
    {
        return $this->render('lessen/index.html.twig', [
            'controller_name' => 'LessenController',
        ]);
    }
}
