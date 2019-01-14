<?php

namespace App\Controller;

use App\Entity\Person;
use App\Form\PersonType;
use App\Repository\PersonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\DateType;



/**
 * @Route("/person")
 */
class PersonController extends Controller
{
    /**
     * @Route("/", name="person_index", methods={"GET"})
     */
    public function index(PersonRepository $personRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'User tried to access a page without being logged in');
        return $this->render('person/index.html.twig', ['persons' => $personRepository->findAll()]);
    }

    /**
     * @Route("/new", name="person_new", methods={"GET","POST"})
     */
    public function new(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $person = new Person();
  
        $form = $this->createFormBuilder($person)
        ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('preprovision', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('lastname', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('dateofbirth',  DateType::class, ['attr' => ['class' => 'js-datepicker', 'placeholder'=>'dd-mm-yyyy'],
        'widget'=>'single_text', 'html5' => false, 'format'=> 'dd-MM-yyyy'
           ])
        ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
        ))
        ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $person = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($person);
          $entityManager->flush();
  
          return $this->redirectToRoute('person_index');
        }
  
        $log = new Logger('addLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('person toegevoegd');
      
  
        return $this->render('person/new.html.twig', array(
          'form' => $form->createView()
        ));
      }

    /**
     * @Route("/{id}/edit", name="person_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $person = new Person();
        $person = $this->getDoctrine()->getRepository(Person::class)->find($id);
  
        $form = $this->createFormBuilder($person)
        ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('firstname', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('preprovision', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('lastname', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('dateofbirth', DateType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-success mt-3')
        ))
        ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('person_index');
        }
  
        $log = new Logger('editLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('person informatie veranderd');
  
        return $this->render('person/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

    /**
     * @Route("/{id}", name="person_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Person $person): Response
    {
        if ($this->isCsrfTokenValid('delete'.$person->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($person);
            $entityManager->flush();
        }

        return $this->redirectToRoute('person_index');
    }
    
}
