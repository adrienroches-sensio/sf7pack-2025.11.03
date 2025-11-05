<?php

namespace App\Form;

use App\Entity\Conference;
use App\Entity\Organization;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ConferenceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('accessible')
            ->add('prerequisites')
            ->add('startAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('endAt', DateType::class, [
                'widget' => 'single_text',
                'input' => 'datetime_immutable',
            ])
            ->add('organizations', EntityType::class, [
                'class' => Organization::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Conference::class,
        ]);
    }
}
