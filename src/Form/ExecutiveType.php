<?php

namespace App\Form;

use App\Entity\Executive;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType as TypeDateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExecutiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mandateStartdate', TypeDateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('mandateEnddate', TypeDateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('mandateType', TextType::class, [
                'required' => false
            ])
            ->add('mandateLimitations', TextareaType::class, [
                'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Executive::class,
        ]);
    }
}
