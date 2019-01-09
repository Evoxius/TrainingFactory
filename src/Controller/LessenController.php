<?php

namespace App\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Symfony\Component\Routing\Annotation\Route;
    use App\Entity\Les;
    use App\Form\LesType;
    use App\Repository\LesRepository;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpFoundation\Request;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    use Symfony\Component\Form\Extension\Core\Type\TextType;
    use Symfony\Component\Form\Extension\Core\Type\TextareaType;
    use Symfony\Component\Form\Extension\Core\Type\SubmitType;
    use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


/**
 * @Route("/les")
 */  
class LessenController extends Controller
{

     /**
     * @Route("/", name="les_list", methods={"GET"})
     */
    public function index(LesRepository $lesRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', null, 'User tried to access a page without being logged in');
        
        return $this->render('les/index.html.twig', ['lessen' => $lesRepository->findAll()]);
    }


    /**
     * @Route("/new", name="les_new", methods={"GET","POST"})
     */
    public function new(Request $request) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $les = new Les();
  
        $form = $this->createFormBuilder($les)
          ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('tijd', TextType::class, array('attr' => array('class' => 'form-control')))
          ->add('dag', ChoiceType::class, array(
            'required' => true,
            'attr' => array('class' => 'form-control'),
            'choices' => array(
              'Ma' => 'Ma',
              'Di' => 'Di',
              'Wo' => 'Wo',
              'Do' => 'Do',
              'Vr' => 'Vr',
              'Za' => 'Za',
              'Zo' => 'Zo',
            )))
          ->add('descriptie', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Create',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
          $les = $form->getData();
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($les);
          $entityManager->flush();
  
          return $this->redirectToRoute('les_list');
        }
  
        $log = new Logger('addLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('les toegevoegd');
      
  
        return $this->render('les/new.html.twig', array(
          'form' => $form->createView()
        ));
      }
  
    /**
     * @Route("/{id}/edit", name="les_edit", methods={"GET","POST"})
     */
      public function edit(Request $request, $id) {
        $this->denyAccessUnlessGranted('ROLE_ADMIN', null, 'User tried to access a page without having ROLE_ADMIN');
        $les = new Les();
        $les = $this->getDoctrine()->getRepository(Les::class)->find($id);
  
        $form = $this->createFormBuilder($les)
        ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('tijd', TextType::class, array('attr' => array('class' => 'form-control')))
        ->add('dag', ChoiceType::class, array(
            'required' => true,
            'attr' => array('class' => 'form-control'),
            'choices' => array(
              'Ma' => 'Ma',
              'Di' => 'Di',
              'Wo' => 'Wo',
              'Do' => 'Do',
              'Vr' => 'Vr',
              'Za' => 'Za',
              'Zo' => 'Zo',
            )))
        ->add('descriptie', TextareaType::class, array('attr' => array('class' => 'form-control')))
          ->add('save', SubmitType::class, array(
            'label' => 'Update',
            'attr' => array('class' => 'btn btn-success mt-3')
          ))
          ->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('les_list');
        }
  
        $log = new Logger('editLogs');
        $streamHandler=new StreamHandler('add.log.html', Logger::INFO);
        $streamHandler->setFormatter(new \Monolog\Formatter\HtmlFormatter());
        $log->pushHandler($streamHandler);
  
        $log->info('les informatie veranderd');
  
        return $this->render('les/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }


    /**
     * @Route("/{id}", name="les_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Les $les): Response
    {
        if ($this->isCsrfTokenValid('delete'.$les->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($les);
            $entityManager->flush();
        }

        return $this->redirectToRoute('les_index');
    }
}
