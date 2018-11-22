<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PrivacyBeleidController extends AbstractController
{
    /**
     * @Route("/privacybeleid", name="privacy_beleid")
     */
    public function index()
    {
        return $this->render('privacy_beleid/index.html.twig', [
            'controller_name' => 'PrivacyBeleidController',
        ]);
    }
}
