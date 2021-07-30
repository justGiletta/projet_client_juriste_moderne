<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addressStreet', TextType::class, [
                'label' => 'RUE',
                'required' => true,
                'attr' => ['class' => ' my-2'],
            ])
            ->add('addressComplement', TextType::class, [
                'label' => 'COMPLÉMENT',
                'required' => false,
                'attr' => ['class' => ' my-2'],
            ])
            ->add('addressZip', IntegerType::class, [
                'label' => 'CODE POSTAL',
                'required' => true,
                'attr' => ['class' => ' my-2'],
            ])
            ->add('addressCity', TextType::class, [
                'label' => 'VILLE',
                'required' => true,
                'attr' => ['class' => ' my-2'],
            ])
            ->add('addressCountry', TextType::class, [
                'label' => 'PAYS',
                'required' => true,
                'attr' => ['class' => ' my-2'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
