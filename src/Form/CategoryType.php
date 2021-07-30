<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Structure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'CATÉGORIE',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('prefixClassification', TextType::class, [
                'label' => 'SOUS-CATÉGORIE',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'DESCRIPTION',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('shareValue', IntegerType::class, [
                'label' => 'VALEUR UNITAIRE DE L\'ACTION',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('nbMinAction', IntegerType::class, [
                'label' => 'NOMBRE MINIMUM DE PART',
                'attr' => ['class' => 'my-3'],
            ])
            ->add('nbMaxAction', IntegerType::class, [
                'label' => 'PLAFOND (optionnel)',
                'attr' => ['class' => 'my-3'],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
