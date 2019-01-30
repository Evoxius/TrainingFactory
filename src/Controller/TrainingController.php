<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Entity\Training;
    use App\Entity\Lesson;
    use App\Entity\Registration;
    use App\Entity\Member;
    use App\Form\TrainingType;
    use App\Repository\TrainingRepository;
    use App\Repository\RegistrationRepository;
    use App\Repository\MemberRepository;
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
    use Symfony\Component\Form\Extension\Core\Type\FileType;
    use Symfony\Component\Form\Extension\Core\Type\TimeType;
    use Symfony\Bridge\Doctrine\Form\Type\EntityType; 
    use Vich\UploaderBundle\Form\Type\VichImageType;
    use App\Service\FileUploader;


class TrainingController extends Controller
{


     /**
     * @Route("/home", name="login", methods={"GET", "POST"})
     */
    public function index(): Response
    {

        $trainings= $this->getDoctrine()->getRepository(Training::class)->findAll();
        return $this->render('bezoeker/index.html.twig', array('trainings' => $trainings));
        
  
    }

     /**
     * @Route("/training/newlesson/{id}", name="training_addlesson", methods={"GET", "POST"})
     */
    public function addLesson(Request $request, $id): Response
    {
      $lesson = new Lesson();
  
      $form = $this->createFormBuilder($lesson)
        ->add('time', TimeType::class, ['attr' => ['class' => 'js-timepicker', 'placeholder'=>'hh:mm'],
        'widget'=>'single_text','html5' => false,])
        ->add('date', DateType::class, ['attr' => ['class' => 'js-datepicker', 'placeholder'=>'dd-mm-yyyy'],
        'widget'=>'single_text', 'html5' => false, 'format'=> 'dd-MM-yyyy'
           ])
        ->add('location', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('max_persons', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('save', SubmitType::class, array(
          'label' => 'Create',
          'attr' => array('class' => 'btn btn-success mt-3')
        ))
        ->getForm();

      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()) { 
        
   
        $repository = $this->getDoctrine()->getRepository(Training::class);
        $trainingid = $repository->find($id);
        $lesson->setTraining($trainingid);
       
       

        $entityManager = $this->getDoctrine()->getManager();
        
       
        $entityManager->persist($lesson);
        $entityManager->flush();

        return $this->redirectToRoute('login');
      }

      return $this->render('lesson/new.html.twig', array(
        'form' => $form->createView()
      ));
    }

     /**
     * @Route("/training/{id}/lessons", name="lesson_list", methods={"GET"})
     */
    public function lessons($id, MemberRepository $memberRepository, RegistrationRepository $registrationRepository): Response
    {
      
      $repository = $this->getDoctrine()->getRepository(Training::class);
      $trainingid = $repository->find($id);
    

        $memberid= $this->get('security.token_storage')->getToken()->getUser();
       
        $beschikbareLessons= $this->getDoctrine()->getRepository(Lesson::class)->getBeschikbareLessons($memberid->getId());
        return $this->render('training/index.html.twig', ['beschikbare_lessons' => $beschikbareLessons, 'members' => $memberRepository->findAll(), 'registrations' => $registrationRepository->findAll()]);
  
    }

     /**
     * @Route("/training/{id}/private", name="lesson_private", methods={"GET"})
     */
    public function private($id): Response
    {
      
      $repository = $this->getDoctrine()->getRepository(Training::class);
      $trainingid = $repository->find($id);



        $memberid= $this->get('security.token_storage')->getToken()->getUser();
        
        $ingeschrevenLessons= $this->getDoctrine()->getRepository(Lesson::class)->getIngeschrevenLessons($memberid->getId());
        return $this->render('training/rooster.html.twig', array('ingeschreven_lessons' => $ingeschrevenLessons));
  
    }

     /**
     * @Route("/training/inschrijven/{id}", name="inschrijven")
     */
    public function inschrijvenLessonAction($id)
    {
      
      $registration = new Registration();

        $repos = $this->getDoctrine()
            ->getRepository(Lesson::class)
            ->find($id);
         
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $registration->setLesson($repos);
        $registration->setMember($usr);
        $registration->setPayment(false);

        $em = $this->getDoctrine()->getManager();
        $em->persist($registration);
        $em->flush();

        return $this->redirectToRoute('lesson_list', [
          'id' => $id,
      ]);
    }

     /**
     * @Route("/training/uitschrijven/{id}", name="uitschrijven")
     */
    public function uitschrijvenLessonAction($id)
    {
      $usr=$this->getUser();
      $repos=$this->getDoctrine()->getManager()->getRepository(Registration::class)->getRegistration($id,$usr);
      //dump($repos);die();
      //$repos = $this->getDoctrine()
      //->getRepository(Registration::class)
      //->getRegistration($id);

       // $usr= $this->get('security.token_storage')->getToken()->getUser();
        //$usr->removeRegistration($repos);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($repos[0]);
        $em->flush();

        return $this->redirectToRoute('lesson_private', [
          'id' => $id,
      ]);
    }




    /**
     * @Route("/training/new", name="training_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $training = new Training();
  
        $form = $this->createFormBuilder($training)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('duration', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('extra_costs', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('image', FileType::class, ['label' => 'Image (PNG/JPEG)', 'data_class' => null])
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $training = $form->getData();

          $file = $training->getImage();
          // Generate a unique name for the file before saving it
          $fileName = md5(uniqid()).'.'.$file->guessExtension();
          // Move the file to the directory where images are stored
          $file->move(
          $this->getParameter('images_directory'),
          $fileName
          );
          // Update the 'image' property to store the PDF file name
          // instead of its contents
          $training->setImage($fileName);
          
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($training);
          $entityManager->flush();
  
          return $this->redirectToRoute('login');
        }
  
        $log = new Logger('addLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('Training toegevoegd');
      
  
        return $this->render('training/new.html.twig', array(
          'form' => $form->createView()
        ));
      }

        /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
  
    /**
     * @Route("/training/{id}/edit", name="training_edit", methods={"GET","POST"})
     */
      public function edit(Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $training = new Training();
        $training = $this->getDoctrine()->getRepository(Training::class)->find($id);
  
        $form = $this->createFormBuilder($training)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control')))
        ->add('duration', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('extra_costs', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('image', FileType::class, ['label' => 'Image (PNG/JPEG)', 'data_class' => null])
        ->add('save', SubmitType::class, array(
          'label' => 'Save',
          'attr' => array('class' => 'btn btn-success mt-3')
        ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('login');
        }
  
        $log = new Logger('editLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('Training informatie veranderd');
  
        return $this->render('training/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }


     /**
     * @Route("/training/{id}", name="training_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Training $training): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($training);
            $entityManager->flush();
        }

        return $this->redirectToRoute('login');
    }
}
