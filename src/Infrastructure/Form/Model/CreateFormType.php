<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model;

use App\Application\Model\Command\CreateModelCommand;
use App\Domain\Model\Model;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class CreateFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'reference',
                TextType::class,
                options: [
                    'label' => 'models.create.form.reference',
                    'attr' => [
                        'placeholder' => 'models.create.form.reference.placeholder',
                    ],
                    'required' => false,
                ],
            )
            ->add(
                'androidCodeName',
                TextType::class,
                options: [
                    'label' => 'models.create.form.androidCodeName',
                    'attr' => [
                        'placeholder' => 'models.create.form.androidCodeName.placeholder',
                    ],
                ],
            )
            ->add(
                'variant',
                IntegerType::class,
                options: [
                    'label' => 'models.create.form.variant',
                    'required' => false,
                ],
            )
            ->add(
                'parentModel',
                EntityType::class,
                options: [
                    'label' => 'models.create.form.parent_model',
                    'class' => Model::class,
                    'query_builder' => function (EntityRepository $er) use ($options) {
                        return $er->createQueryBuilder('m')
                            ->join('m.serie', 's', 'WITH', 's = :serie')
                            ->setParameter('serie', $options['serieUuid'])
                            ->orderBy('s.name', 'ASC')
                            ->addOrderBy('m.reference', 'ASC');
                    },
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
        $resolver->setRequired('serieUuid');
    }
}
