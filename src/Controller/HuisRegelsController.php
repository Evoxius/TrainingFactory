<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HuisRegelsController extends AbstractController
{
    /**
     * @Route("/huisregels", name="huis_regels")
     */
    public function index()
    {
        return $this->render('huis_regels/index.html.twig', [
            'controller_name' => 'HuisRegelsController',
        ]);
    }
}
