<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Serie;

use App\Application\Serie\Command\CreateSerieCommand;
use App\Domain\Model\Manufacturer;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'manufacturer',
                EntityType::class,
                options: [
                    'label' => 'series.create.form.manufacturer',
                    'class' => Manufacturer::class,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('m')
                            ->orderBy('m.name', 'ASC');
                    },
                ],
            )
            ->add(
                'name',
                TextType::class,
                options: [
                    'label' => 'series.create.form.name',
                    'attr' => [
                        'placeholder' => 'series.create.form.name.placeholder',
                    ],
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateSerieCommand::class,
        ]);
    }
}
