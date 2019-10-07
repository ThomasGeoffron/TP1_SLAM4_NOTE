<?php

namespace App\Form;

use App\Entity\Visiteur;
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

class UpdateVisiteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class,array('label'=>'Nom:','attr'=>array('class'=>'form-control','placeholder'=>'Nom...')))
            ->add('prenom',TextType::class,array('label'=>'Prénom:','attr'=>array('class'=>'form-control','placeholder'=>'Prénom...')))
            ->add('adresse',TextType::class,array('label'=>'Adresse:','attr'=>array('class'=>'form-control','placeholder'=>'Adresse...')))
            ->add('telephone',TextType::class,array('label'=>'Téléphone:','attr'=>array('class'=>'form-control','placeholder'=>'Téléphone...')))
            ->add('Valider',SubmitType::class, array('label' =>'Valider','attr' => array('class'=>'btn btn-primary btn-block')))
            ->add('Annuler',ResetType::class, array('label'=>'Annuler','attr' => array('class' => 'btn btn-primary btn-block')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Visiteur::class,
        ]);
    }
}
