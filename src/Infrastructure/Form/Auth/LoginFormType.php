<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Auth;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

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
                ],
            );
    }
}
