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

     /**
     * @Route("/home/huisregels", name="huis_regels")
     */
    public function huisregels()
    {
        return $this->render('homepage/huisregels.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/home/cookies", name="cookies")
     */
    public function cookies()
    {
        return $this->render('homepage/cookies.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

    /**
     * @Route("/home/privacybeleid", name="privacy_beleid")
     */
    public function privacybeleid()
    {
        return $this->render('homepage/privacybeleid.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

     /**
     * @Route("/home/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('homepage/contact.html.twig', [
            'controller_name' => 'HomepageController',
        ]);
    }

}
