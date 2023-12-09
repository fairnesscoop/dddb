<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model\AndroidCodeName;

use App\Application\Model\Command\SetAndroidCodeNameCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class SetAndroidCodeNameFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'androidCodeName',
                TextType::class,
                options: [
                    'label' => 'models.form.androidCodeName',
                ],
            )
            ->add(
                'variant',
                IntegerType::class,
                options: [
                    'label' => 'models.form.variant',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SetAndroidCodeNameCommand::class,
        ]);
    }
}
