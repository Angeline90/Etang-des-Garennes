<?php

namespace App\Form;


use App\Entity\Cottage;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CottageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('price')
            ->add('capacity')
            ->add('owners', EntityType::class, [
                // looks for choices from this entity
                'class' => User::class,
                'choices' => $options['owners'],

                // uses the User.username property as the visible option string
                'choice_label' => 'email',

                // used to render a select box, check boxes or radios
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Cottage::class,
            'owners' => array(),
        ]);
    }
}
