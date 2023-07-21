<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model;

use App\Application\Model\Command\CreateCodeTacCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateCodeTacFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'codeTac',
                TextType::class,
                options: [
                    'label' => 'models.create.form.codeTac',
                    'attr' => [
                        'placeholder' => 'models.create.form.codeTac.placeholder',
                    ],
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateCodeTacCommand::class,
        ]);
    }
}
