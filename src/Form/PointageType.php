<?php

namespace App\Form;

use App\Entity\Pointage;
use App\Entity\Reservation;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PointageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $builder
            ->add('sortie', DateTimeType::class,array(
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'minutes' => array('0','15','30','45')))
            ->add('entree', DateTimeType::class,array(
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'minutes' => array('0','15','30','45')))
            ->add('kiloAvant', IntegerType::class,array(
                'label' => 'Kilométrage',
                'attr' => array('class'=>'form-control')
            ))
            ->add('kiloApres', IntegerType::class,array(
                'label' => 'Kilométrage', 
                'attr' => array('class'=>'form-control')
            ))
            ->add('obsAvant', TextareaType::class, array(
                'label' => 'Observations',
                'attr' => array('rows'=>'3', 'placeholder'=>"Observations sur le véhicule", 'class'=>'form-control')
            ))
            ->add('obsApres', TextareaType::class, array(
                'label' => 'Observations',
                'attr' => array('rows'=>'3', 'placeholder'=>"Observations sur le véhicule", 'class'=>'form-control')
            ))
            ->add('emplacement', TextType::class,array(
                'label' => 'Emplacement du véhicule',
                'attr' => array('class' => 'form-control')
            ))
            ->add('reservation', EntityType::class, array(
                'label' => 'Vos réservations non pointés :',
                'class' => Reservation::class,
                'choices' => $options['reservations']

            ))

            ->add('valider', SubmitType::class, array(
                'attr' => array('class'=>'btn btn-success')
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pointage::class,
            'reservations' => null
        ]);
    }
}
