<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class)
        ->add('firstname', TextType::class)
        ->add('email', EmailType::class)
            // ->add('agreeTerms', CheckboxType::class, [
            //     'mapped' => false,
            //     'constraints' => [
            //         new IsTrue([
            //             'message' => 'You should agree to our terms.',
            //         ]),
            //     ],
            // ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class])
                
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                // 'mapped' => false,
                
                // 'attr' => ['autocomplete' => 'new-password'],
                
                // 'constraints' => [
                //     new Length([
                //         'min' => 6,
                //         'minMessage' => 'Le mot de passe doit être de  {{ limit }} caractères minimum',
                //         // max length allowed by Symfony for security reasons
                //         'max' => 20,
                //         'maxMessage' => 'Le mot de passe doit être de  {{ limit }} caractères maximum',
                //     ]),
                // ],
          
            ->add('phone', TextType::class)
            ->add('adress', TextareaType::class) 
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
