<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model\Attribute;

use App\Application\Battery\Command\AddBatteryReferenceCommand;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddBatteryReferenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'batteryReference',
                TextType::class,
                options: [
                    'label' => 'attributes.battery.form.label',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddBatteryReferenceCommand::class,
        ]);
    }
}
