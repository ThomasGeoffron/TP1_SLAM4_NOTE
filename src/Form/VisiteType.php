<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('suite',TextType::class,array('label'=>'Suite :','attr'=>array('class'=>'form-control','placeholder'=>'Suite...')))
            ->add('date',DateType::class,array('label'=>'Date :','attr'=>array('class'=>'form-control','placeholder'=>'Date...')))
            ->add('bien',EntityType::class,array('label'=>'Bien : ','class'=>'App\Entity\Bien', 'choice_label'=>'localisation', 'placeholder'=>'--Choisir le bien--'))
            ->add('visiteur',EntityType::class,array('label'=>'Visiteur : ','class'=>'App\Entity\Visiteur', 'choice_label'=>'nom', 'placeholder'=>'--Choisir le visiteur--'))
            ->add('Valider',SubmitType::class, array('label' =>'Valider','attr' => array('class'=>'btn btn-primary btn-block')))
            ->add('Annuler',ResetType::class, array('label'=>'Annuler','attr' => array('class' => 'btn btn-primary btn-block')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
