<?php

namespace App\Form;

use App\Entity\Bien;
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

class BienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nb_piece',NumberType::class,array('label'=>'Nombre de pièces :','attr'=>array('class'=>'form-control','placeholder'=>'Nombre de pièces...')))
            ->add('nb_chambre',NumberType::class,array('label'=>'Nombre de chambres :','attr'=>array('class'=>'form-control','placeholder'=>'Nombre de chambres...')))
            ->add('superficie',NumberType::class,array('label'=>'Superficie :','attr'=>array('class'=>'form-control','placeholder'=>'Superficie...')))
            ->add('prix',NumberType::class,array('label'=>'Prix :','attr'=>array('class'=>'form-control','placeholder'=>'Prix...')))
            ->add('chauffage',TextType::class,array('label'=>'Chauffage :','attr'=>array('class'=>'form-control','placeholder'=>'Chauffage...')))
            ->add('annee',NumberType::class,array('label'=>'Annee :','attr'=>array('class'=>'form-control','placeholder'=>'Annee...')))
            ->add('localisation',TextType::class,array('label'=>'Localisation :','attr'=>array('class'=>'form-control','placeholder'=>'Localisation...')))
            ->add('etat',TextType::class,array('label'=>'Etat :','attr'=>array('class'=>'form-control','placeholder'=>'Etat...')))
            ->add('type',EntityType::class,array('label'=>'Type : ','class'=>'App\Entity\Type', 'choice_label'=>'libelle', 'placeholder'=>'--Choisir le Type--'))
            ->add('Valider',SubmitType::class, array('label' =>'Valider','attr' => array('class'=>'btn btn-primary btn-block')))
            ->add('Annuler',ResetType::class, array('label'=>'Annuler','attr' => array('class' => 'btn btn-primary btn-block')))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Bien::class,
        ]);
    }
}
