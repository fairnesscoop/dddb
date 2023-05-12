<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model;

use App\Application\Model\Command\CreateModelCommand;
use App\Domain\Model\Model;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
                'codeName',
                TextType::class,
                options: [
                    'label' => 'models.create.form.code_name',
                    'attr' => [
                        'placeholder' => 'models.create.form.code_name.placeholder',
                    ],
                ],
            )
            ->add(
                'parentModel',
                EntityType::class,
                options: [
                    'label' => 'models.create.form.parent_model',
                    'class' => Model::class,
                    'empty_data' => null,
                    'placeholder' => 'common.none',
                    'required' => false,
                    'help' => 'models.create.form.parent_model.help',
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreateModelCommand::class,
        ]);
    }
}
