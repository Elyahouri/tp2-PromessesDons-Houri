<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'required'=>true,
                "label"=>'Nom de la campagne'
            ])
            ->add('description', TextType::class,[
                'required'=>true,
                "label"=>'Description'
            ])
            ->add('activated',CheckboxType::class,[
                'required'=>false,
                "label"=>'Campagne activé'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
