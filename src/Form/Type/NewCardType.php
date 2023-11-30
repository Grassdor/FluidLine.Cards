<?php

namespace App\Form\Type;

use App\Entity\NewCard;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class NewCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('cardName', TextType::class, ['label' => "Название карточки"])
        ->add('cardHost', TextType::class, ['label' => "Ссылка на хост"])
        ->add('cardLink', TextType::class, ['label' => "Ссылка на"])
        ->add('cardId', HiddenType::class)
        ->add('save', SubmitType::class, ['label' => 'Создать карточку'])
        ->add('reset', ResetType::class, ['label' => 'Отмена'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NewCard::class,
        ]);
    }
}