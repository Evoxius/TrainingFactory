<?php

namespace App\Controller;
require __DIR__ . '../../../vendor/autoload.php';

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends Controller
{
    /**
     * @Route("/home", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
            // get the login error if there is one
            $error = $authUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authUtils->getLastUsername();
            if (isset($error)) {
                $this->addFlash(
                    'error',
                    'Gegevens kloppen niet. Probeer opnieuw.'
                );
            } else {
    
                $this->addFlash(
                    'notice',
                    'Vul uw gegevens in'
                );
            }
        return $this->render('homepage/index.html.twig', [
            'error'         => $error,
            'last_username' => $lastUsername
        ]);
      
    }

    /**
     *  @Route("/logout", name="logout")
     */

    public function logout()
    {
      
    }

    /**
     * @Route("registreren", name="registreren")
     */
    public function registreren(Request $request,UserPasswordEncoderInterface $passwordEncoder)
    {
        // 1) build the form
        $user = new Member();
        $form = $this->createForm(MemberType::class, $user);
        $form->add('save', SubmitType::class, array('label'=>"registreren"));
        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            // 2.5) Is the user new, gebruikersnaam moet uniek zijn
            $repository=$this->getDoctrine()->getRepository(Member::class);
            $bestaande_user=$repository->findOneBy(['username'=>$form->getData()->getUsername()]);

            if($bestaande_user==null)
            {
                // 3) Encode the password (you could also do this via Doctrine listener)
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setRoles(['ROLE_USER']);
                // 4) save the User!
                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $this->addFlash(
                    'notice',
                    $user->getUsername().' is geregistreerd!'
                );

                return $this->redirectToRoute('homepage');
            }
            else
            {
                $this->addFlash(
                    'error',
                    $user->getUsername()." bestaat al!"
                );
                return $this->render('bezoeker/registreren.html.twig', [
                    'form'=>$form->createView()
                ]);
            }
        }

        return $this->render('bezoeker/registreren.html.twig', [
            'form'=>$form->createView()
        ]);
    }

}
