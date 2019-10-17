<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Utilisateurs;
use App\Service\ReservationService;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('personne')
            ->add('debut', DateTimeType::class,array(
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'minutes' => array('0','15','30','45')

            ))
            ->add('fin', DateTimeType::class, array(
                'label' => false,
                'date_widget' => 'single_text',
                'time_widget' => 'choice',
                'minutes' => array('0','15','30','45')
            ))
            ->add('optPlace', ChoiceType::class, array(
                'choices'  => array(
                    'Indifférent' => 0,
                    '2 places' => 2,
                    '4 places' => 4)
            ))
            ->add('load', SubmitType::class, array('label' => 'Charger', 'attr' => ['class' => 'btn btn-primary']))
            ->add('save', SubmitType::class, array('label' => 'Sauvegarder','attr' => ['class' => 'btn btn-success', 'onclick' => 'sauvegardeEnCours()']));
            
            
            /*$builder->addEventListener(
                FormEvents::PRE_SUBMIT,
                function(FormEvent $event)
                {
                    $form = $event->getForm();
                    $data = $event->getData();
                    $form->add('save', SubmitType::class, array('label' => 'Sauvegarder','attr' => ['class' => 'btn btn-success', 'onclick' => 'sauvegardeEnCours()']));
                }
            );*/
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // important part; unique key
            'csrf_token_id'   => 'form_intention',
        ]);
        
    }
}
