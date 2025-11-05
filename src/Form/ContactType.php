<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'help' => 'Your name',
                'constraints' => [
                    new NotNull(),
                    new Length(min: 3),
                ],
                'label' => 'Full name',
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'attr' => [
                    'placeholder' => 'name@example.com',
                ],
                'constraints' => [
                    new NotNull(),
                    new Email(),
                ],
                'label' => 'Email address',
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'help' => 'Subject of your message',
                'constraints' => [
                    new NotNull(),
                    new Length(min: 3),
                ],
                'label' => 'Subject',
            ])
            ->add('message', TextareaType::class, [
                'required' => true,
                'constraints' => [
                    new NotNull(),
                    new Length(min: 30),
                ],
                'label' => 'Message',
            ])
        ;
    }
}
