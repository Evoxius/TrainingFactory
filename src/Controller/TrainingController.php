<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Entity\Training;
    use App\Form\TrainingType;
    use App\Repository\TrainingRepository;
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
        ->add('image', FileType::class, ['label' => 'Image (PNG/JPEG)'])
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $training = $form->getData();

          $file = $product->getImage();
          $fileName = $fileUploader->upload($file);

          $product->setImage($fileName);

  
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
        ->add('image', FileType::class, ['label' => 'Image (PNG/JPEG)'])
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
    public function delete(Request $request, Training $trainingsraining): Response
    {
        if ($this->isCsrfTokenValid('delete'.$training->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($training);
            $entityManager->flush();
        }

        return $this->redirectToRoute('login');
    }
}
