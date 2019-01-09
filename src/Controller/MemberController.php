<?php

namespace App\Controller;

use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * @Route("/member")
 */
class MemberController extends Controller
{
    /**
     * @Route("/", name="member_index", methods={"GET"})
     */
    public function index(MemberRepository $memberRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'User tried to access a page without being logged in');
        return $this->render('member/index.html.twig', ['members' => $memberRepository->findAll()]);
    }

    /**
     * @Route("/new", name="member_new", methods={"GET","POST"})
     */
    public function new(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $member = new Member();
  
        $form = $this->createFormBuilder($member)
        ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
        ))
        ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $member = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($member);
          $entityManager->flush();
  
          return $this->redirectToRoute('member_index');
        }
  
        $log = new Logger('addLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('member toegevoegd');
      
  
        return $this->render('member/new.html.twig', array(
          'form' => $form->createView()
        ));
      }

    /**
     * @Route("/{id}/edit", name="member_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $member = new Member();
        $member = $this->getDoctrine()->getRepository(Member::class)->find($id);
  
        $form = $this->createFormBuilder($member)
        ->add('username', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('password', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('email', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-success mt-3')
        ))
        ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('member_index');
        }
  
        $log = new Logger('editLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('member informatie veranderd');
  
        return $this->render('member/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

    /**
     * @Route("/{id}", name="member_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Member $member): Response
    {
        if ($this->isCsrfTokenValid('delete'.$member->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($member);
            $entityManager->flush();
        }

        return $this->redirectToRoute('member_index');
    }
    
}
