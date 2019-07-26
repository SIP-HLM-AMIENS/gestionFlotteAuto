<?php

namespace App\Form;

use App\Entity\Voiture;
use App\Entity\Controle;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ControleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, array(
                'label' => false,
            ))
            ->add('dateLimite', DateType::class, array(
                'label' =>false,
            ))
            ->add('voiture', EntityType::class, array(
                'class' => Voiture::class,
                'disabled' => true
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Controle::class,
        ]);
    }
}
