<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\User;

use App\Domain\User\Enum\RoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class CreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class,
                options: [
                    'label' => 'users.create.form.firstName',
                    'attr' => [
                        'placeholder' => 'users.create.form.firstName.placeholder',
                    ],
                ],
            )
            ->add(
                'lastName',
                TextType::class,
                options: [
                    'label' => 'users.create.form.lastName',
                    'attr' => [
                        'placeholder' => 'users.create.form.lastName.placeholder',
                    ],
                ],
            )
            ->add(
                'email',
                EmailType::class,
                options: [
                    'label' => 'users.create.form.email',
                    'attr' => [
                        'placeholder' => 'users.create.form.email.placeholder',
                    ],
                ],
            )
            ->add(
                'password',
                RepeatedType::class,
                options: [
                    'type' => PasswordType::class,
                    'invalid_message' => 'users.create.form.password.nomatch',
                    'first_options' => [
                        'label' => 'users.create.form.password',
                        'attr' => [
                            'placeholder' => 'users.create.form.password.placeholder',
                        ],
                    ],
                    'second_options' => [
                        'label' => 'users.create.form.password.confirm',
                        'attr' => [
                            'placeholder' => 'users.create.form.password.confirm.placeholder',
                        ],
                    ],
                ],
            )->add(
                'role',
                ChoiceType::class,
                [
                    'choices' => [
                        'Contributor' => RoleEnum::CONTRIBUTOR,
                        'Admin' => RoleEnum::ADMIN,
                    ],
                ],
            );
    }
}
