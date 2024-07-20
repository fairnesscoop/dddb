<?php

declare(strict_types=1);

namespace App\Infrastructure\Form\Model\Attribute;

use App\Application\SupportedOsList\Command\AddSupportedOsCommand;
use App\Domain\Os\OsVersionList;
use App\Domain\Os\Version as OsVersion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddSupportedOsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        static $osVersionList = new OsVersionList();

        $builder
            ->add(
                'osVersion',
                ChoiceType::class,
                options: [
                    'label' => 'attributes.supportedOsList.form.osVersion',
                    'choices' => $osVersionList,
                    'choice_value' => 'id',
                    'choice_label' => static fn (?OsVersion $version) => $version?->getFullName(),
                    'placeholder' => '---',
                ],
            )
            ->add(
                'helpLink',
                UrlType::class,
                options: [
                    'label' => 'attributes.supportedOsList.form.helpLink',
                    'required' => false,
                ],
            )
            ->add(
                'comment',
                TextareaType::class,
                options: [
                    'label' => 'attributes.supportedOsList.form.comment',
                    'required' => false,
                ],
            )
            ->add(
                'recoveryIpfsCid',
                TextType::class,
                options: [
                    'label' => 'attributes.supportedOsList.form.recoveryIpfsCid',
                    'required' => false,
                ],
            )
            ->add(
                'romIpfsCid',
                TextType::class,
                options: [
                    'label' => 'attributes.supportedOsList.form.romIpfsCid',
                    'required' => false,
                ],
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AddSupportedOsCommand::class,
        ]);
    }
}
