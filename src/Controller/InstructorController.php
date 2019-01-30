<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Entity\Training;
use App\Form\InstructorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Repository\InstructorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/instructor")
 */
class InstructorController extends AbstractController
{
    /**
     * @Route("/", name="instructor_index", methods={"GET"})
     */
    public function index(InstructorRepository $instructorRepository): Response
    {
        return $this->render('instructor/index.html.twig', [
            'instructors' => $instructorRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="instructor_new", methods={"GET","POST"})
     */
    public function new(Request $request,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $trainings= $this->getDoctrine()->getRepository(Training::class)->findAll();
        $user = new Instructor();
        $form = $this->createForm(InstructorType::class, $user);
        $form->add('save', SubmitType::class, array('label'=>"registreren"));
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // 2.5) Is the user new, gebruikersnaam moet uniek zijn
            $repository=$this->getDoctrine()->getRepository(Instructor::class);
            $bestaande_user=$repository->findOneBy(['username'=>$form->getData()->getUsername()]);

            if($bestaande_user==null)
            {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles(['ROLE_INSTRUCTOR']);
                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    $user->getUsername().' is geregistreerd!'
                );

                return $this->redirectToRoute('login');
            }
            else
            {
                $this->addFlash(
                    'error',
                    $user->getUsername()." bestaat al!"
                );
                return $this->render('instructor/new.html.twig', [
                    'form'=>$form->createView(),
                    'trainings' => $trainings,
                ]);
            }
        }

        return $this->render('instructor/new.html.twig', [
            'form'=>$form->createView(),
            'trainings' => $trainings,
        ]);
    }

    /**
     * @Route("/{id}", name="instructor_show", methods={"GET"})
     */
    public function show(Instructor $instructor): Response
    {
        return $this->render('instructor/show.html.twig', [
            'instructor' => $instructor,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="instructor_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Instructor $instructor): Response
    {
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('instructor_index', [
                'id' => $instructor->getId(),
            ]);
        }

        return $this->render('instructor/edit.html.twig', [
            'instructor' => $instructor,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="instructor_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Instructor $instructor): Response
    {
        if ($this->isCsrfTokenValid('delete'.$instructor->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($instructor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('instructor_index');
    }
}
