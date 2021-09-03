<?php

namespace App\Form\Type;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',null,[
            'required' => 'required',
            'trim' => true,
            ])
            ->add('name')
            ->add('description')
            ->add('brand')
            ->add('category')
            ->add('price')
           

        
            //->add('save', SubmitType::class)
        ;
    }
}