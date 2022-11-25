<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName',TextType::class,[
                "required"=>true,
                'label'=>'Prenom'
            ])
            ->add('lastName',TextType::class,[
                "required"=>true,
                'label'=>'Nom'
            ])
            ->add('email',EmailType::class,[
                "required"=>true,
                'label'=>'Email'
            ])
            ->add('password',PasswordType::class,[
                "required"=>true,
                'label'=>'Mot de passe'
            ])
            //->add('roles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
