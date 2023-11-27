<?php

namespace App\Form\Type;

use App\Entity\NewCard;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;

class EditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // dd($options);
        $builder
        ->add('cardName', TextType::class, ['attr' => ['value' => $options["empty_data"]->getCardName()]])
        ->add('cardHost', TextType::class, ['attr' => ['value' => $options["empty_data"]->getCardHost()]])
        ->add('cardLink', TextType::class, ['attr' => ['value' => $options["empty_data"]->getCardLink()]])
        ->add('id', HiddenType::class, ['attr' => ['value' => $options["empty_data"]->getCardName()]])
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