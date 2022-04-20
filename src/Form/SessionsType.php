<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formateur;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('intituleSession', TextType::class)
            ->add('dateDebut', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('dateFin', DateType::class,[
                'widget' => 'single_text'
            ])
            ->add('nbPlacesTheorique',NumberType::class)
            ->add('formateur',EntityType::class, [
                'class' => Formateur::class,
                'choice_label' => 'nomFormateur'
            ])
            ->add('formation',EntityType::class, [
                'class' => Formation::class,
                'choice_label' => 'nomFormation'
            ])
            ->add('valider', SubmitType::class) 
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
