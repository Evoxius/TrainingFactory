<?php

namespace App\Form;

use App\Entity\Instructor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;

class InstructorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username',TextType::class, array('label' => 'Gebruikersnaam'))
            ->add('plainPassword', RepeatedType::class, array('type' => PasswordType::class,'first_options' => array('label' => 'Wachtwoord'),'second_options' => array('label' => 'Herhaal wachtwoord'),))
            ->add('firstname',TextType::class, array('label' => 'First name'))
            ->add('lastname',TextType::class, array('label' => 'Last name'))
            ->add('preprovision')
            ->add('dateofbirth', DateType::class, ['attr' => ['class' => 'js-datepicker', 'placeholder'=>'dd-mm-yyyy'],
            'widget'=>'single_text', 'html5' => false, 'format'=> 'dd-MM-yyyy', 'label'=> 'Date of Birth'
               ])
            ->add('hiring_date', DateType::class, ['attr' => ['class' => 'js-datepicker', 'placeholder'=>'dd-mm-yyyy'],
            'widget'=>'single_text', 'html5' => false, 'format'=> 'dd-MM-yyyy', 'label'=> 'Huur datum'
               ])
            ->add('salary',TextType::class, array('label' => 'Salary'))
            ->add('social_sec_number',TextType::class, array('label' => 'Social Security Number'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Instructor::class,
        ]);
    }
}
