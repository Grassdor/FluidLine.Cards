<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('username', TextType::class, [
            'label' => 'Имя пользователя',
            'row_attr' => [
                'class' => "form-floating mb-3"
            ],
            'attr' => [
                'class' => 'form-control',
                'placeholder' => ''
            ]
        ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
                'row_attr' => [
                    'class' => "form-floating mb-3"
                ],
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => ''
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Войти',
                'row_attr' => [
                    'class' => 'd-flex w-100'
                ],
                'attr' => [
                    'class' => "btn mx-auto"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'row_attr' => [
                "class" => 'd-flex flex-column'
            ],
        ]);
    }
}