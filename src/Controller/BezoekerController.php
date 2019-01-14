<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class BezoekerController extends Controller
{
    /**
     * @Route("/home2", name="homepage")
     */
    public function index()
    {
        return $this->render('bezoeker/index.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

    /**
     * @Route("/home/dagpas", name="gratis_dagpas")
     */
    public function dagpas()
    {
        return $this->render('bezoeker/dagpas.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

     /**
     * @Route("/home/huisregels", name="huis_regels")
     */
    public function huisregels()
    {
        return $this->render('bezoeker/huisregels.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

    /**
     * @Route("/home/cookies", name="cookies")
     */
    public function cookies()
    {
        return $this->render('bezoeker/cookies.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

    /**
     * @Route("/home/privacybeleid", name="privacy_beleid")
     */
    public function privacybeleid()
    {
        return $this->render('bezoeker/privacybeleid.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

     /**
     * @Route("/home/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('bezoeker/contact.html.twig', [
            'controller_name' => 'BezoekerController',
        ]);
    }

}
