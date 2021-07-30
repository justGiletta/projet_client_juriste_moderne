<?php

namespace App\Form;

use App\Entity\Associate;
use App\Entity\Category;
use App\Entity\College;
use App\Entity\LegalPerson;
use App\Entity\NaturalPerson;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('subscriptionDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('caApprovalDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('agApprovalDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('firstSubscribedCapitalPaymentsDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('numberOfShare', IntegerType::class, [
                'required' => false
            ])
            ->add('subscribedCapitalAmountPaidUp', IntegerType::class, [
                'required' => false
            ])
            ->add('withdrawalRequestDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('repaymentDate', DateType::class, [
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('repaymentAmount', IntegerType::class, [
                'required' => false
            ])
            ->add('expertiseField', TextareaType::class, [
                'required' => false
            ])
            ->add('referenceProjects', TextareaType::class, [
                'required' => false
            ])
            ->add('category', EntityType::class, [
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => false,
            ])
            ->add('college', EntityType::class, [
                'required' => true,
                'class' => College::class,
                'choice_label' => 'name',
                'multiple' => false,
                'expanded' => false,
                'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Associate::class,
        ]);
    }
}
