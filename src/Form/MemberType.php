<?php

namespace App\Form;

use App\Entity\Member;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;

class MemberType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class
                , array(
             'label' => 'Gebruikersnaam'))
            ->add('plainPassword', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Wachtwoord'),
                'second_options' => array('label' => 'Herhaal wachtwoord'),
            ))
            ->add('firstname',TextType::class
            , array(
         'label' => 'First name'))
            ->add('preprovision')
            ->add('lastname',TextType::class
            , array(
         'label' => 'Last name'))
         ->add('dateofbirth', TextType::class
         , array(
      'label' => 'Date of Birth'))
            ->add('street',TextType::class
            , array(
         'label' => 'Street'))
            ->add('place',TextType::class
            , array(
         'label' => 'Place'));
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
