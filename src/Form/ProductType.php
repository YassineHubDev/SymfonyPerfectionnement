<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom'
            ])
            ->add('Description')
            ->add('Price', null, [
                'label' => 'Prix'
            ])
            ->add('etatPublication', null, [
                'label' => 'Le produit doit-il être prublié ?'
            ])
            ->add('imageName', null, [
                'label' => 'Upload d\'image à venir'
            ])
            ->add('category', null, [
                'label' => 'Catégorie associée'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Créer le produit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
