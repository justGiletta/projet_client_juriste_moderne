<?php

namespace App\Form;

use App\Entity\College;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollegeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'NOM',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('prefixClassification', TextType::class, [
                'label' => 'TYPE D\'ASSOCIÉ',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'TYPE DE VOTE',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('nbVotingRight', NumberType::class, [
                'label' => 'RÉPARTITION',
                'attr' => ['class' => 'my-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => College::class,
        ]);
    }
}
