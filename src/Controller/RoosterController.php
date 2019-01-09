<?php

namespace App\Controller;

use App\Entity\Rooster;
use App\Form\RoosterType;
use App\Repository\RoosterRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rooster")
 */
class RoosterController extends AbstractController
{
    /**
     * @Route("/", name="rooster_index", methods={"GET"})
     */
    public function index(RoosterRepository $roosterRepository): Response
    {
        return $this->render('rooster/index.html.twig', ['roosters' => $roosterRepository->findAll()]);
    }

    /**
     * @Route("/new", name="rooster_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rooster = new Rooster();
        $form = $this->createForm(RoosterType::class, $rooster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rooster);
            $entityManager->flush();

            return $this->redirectToRoute('rooster_index');
        }

        return $this->render('rooster/new.html.twig', [
            'rooster' => $rooster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rooster_show", methods={"GET"})
     */
    public function show(Rooster $rooster): Response
    {
        return $this->render('rooster/show.html.twig', ['rooster' => $rooster]);
    }

    /**
     * @Route("/{id}/edit", name="rooster_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rooster $rooster): Response
    {
        $form = $this->createForm(RoosterType::class, $rooster);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('rooster_index', ['id' => $rooster->getId()]);
        }

        return $this->render('rooster/edit.html.twig', [
            'rooster' => $rooster,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="rooster_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rooster $rooster): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rooster->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rooster);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rooster_index');
    }
}
