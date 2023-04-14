<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Security;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class LoginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                EmailType::class,
                options: [
                    'label' => 'login.form.email',
                    'attr' => [
                        'placeholder' => 'login.form.email.placeholder',
                    ],
                    'mapped' => false,
                ],
            )
            ->add(
                'password',
                PasswordType::class,
                options: [
                    'label' => 'login.form.password',
                    'attr' => [
                        'placeholder' => 'login.form.password.placeholder',
                    ],
                    'mapped' => false,
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'csrf_field_name' => '_csrf_token',
            'csrf_token_id' => 'authenticate',
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
