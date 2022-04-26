<?php
# model de transformation d'un objet session en son identifiant ID
namespace App\Form;



use App\Entity\Planifier;
use App\Entity\FormationModule;
use Symfony\Component\Form\AbstractType;
use App\Form\DataTransformer\SessionTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class PlannifiersType extends AbstractType
{
    private $transformer;

    public function __construct(SessionTransformer $transformer){
        $this->transformer = $transformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', NumberType::class, [
                'label' => 'durée(jours)',
                'attr' =>['min'=>'1/2', 'max' => '15']
            ])
            ->add('moduleFormation', EntityType::class,[
                'label' => 'module',
                'class' => FormationModule::class,
                'choice_label'=>'nomModule'
            ])
            ->add('sessionDuree', HiddenType::class)
        ;
        $builder
                ->get('sessionDuree')
                ->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Planifier::class,
        ]);
    }
}
