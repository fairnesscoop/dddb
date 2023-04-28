<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Manufacturer;

use App\Application\Manufacturer\Command\CreateManufacturerCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                TextType::class,
                options: [
                    'label' => 'manufacturers.create.form.name',
                    'attr' => [
                        'placeholder' => 'manufacturers.create.form.name.placeholder',
                    ],
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateManufacturerCommand::class,
        ]);
    }
}
