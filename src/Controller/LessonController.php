<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Entity\Lesson;
    use App\Form\LessonType;
    use App\Repository\LessonRepository;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
    use Symfony\Component\Form\Extension\Core\Type\DateType;


/**
 * @Route("/lesson")
 */  
class LessonController extends Controller
{

     /**
     * @Route("/", name="lesson_list", methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'User tried to access a page without being logged in');

        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $beschikbareLesson=$this->getDoctrine()
            ->getRepository(Lesson::class)
        ->getBeschikbareLesson($usr->getId());

        $ingeschrevenLesson=$this->getDoctrine()
            ->getRepository(Lesson::class)
            ->getIngeschrevenLesson($usr->getId());

        $totaal=$this->getDoctrine()
            ->getRepository(Lesson::class)
            ->getTotaal($ingeschrevenLesson);


        return $this->render('lesson/index.html.twig', [
                'beschikbare_lesson'=>$beschikbareLesson,
                'ingeschreven_Lesson'=>$ingeschrevenLesson,
                'totaal'=>$totaal,
        ]);
        
  
    }



    /**
     * @Route("/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenLessonAction($id)
    {

        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->find($id);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->addLesson($lesson);

        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();

        return $this->redirectToRoute('lesson');
    }

    /**
     * @Route("/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenLessonAction($id)
    {
        $lesson = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->find($id);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->removeLesson($lesson);
        $em = $this->getDoctrine()->getManager();
        $em->persist($usr);
        $em->flush();
        return $this->redirectToRoute('lesson');
    }


    /**
     * @Route("/new", name="lesson_new", methods={"GET","POST"})
     */
    public function new(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $lesson = new Lesson();
  
        $form = $this->createFormBuilder($lesson)
          ->add('time', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('date', DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('location', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('max_persons', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $lesson = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($lesson);
          $entityManager->flush();
  
          return $this->redirectToRoute('lesson_list');
        }
  
        $log = new Logger('addLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('lesson toegevoegd');
      
  
        return $this->render('lesson/new.html.twig', array(
          'form' => $form->createView()
        ));
      }
  
    /**
     * @Route("/{id}/edit", name="lesson_edit", methods={"GET","POST"})
     */
      public function edit(Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $lesson = new Lesson();
        $lesson = $this->getDoctrine()->getRepository(Lesson::class)->find($id);
  
        $form = $this->createFormBuilder($lesson)
        ->add('time', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('date', DateType::class, array('attr' => array('class' => 'form-control')))
          ->add('location', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('max_persons', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('lesson_list');
        }
  
        $log = new Logger('editLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('lesson informatie veranderd');
  
        return $this->render('lesson/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }


    /**
     * @Route("/{id}", name="lesson_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Lesson $lesson): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lesson->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lesson);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lesson_index');
    }
}
