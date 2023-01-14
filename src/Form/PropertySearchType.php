<?php

namespace App\Form;

use App\Entity\PropertyOptions;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('minSurface', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Surface minimale'
                ]
            ])
            ->add('maxPrice', IntegerType::class, [
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' => 'Budget maximal'
                ]
            ])
            ->add('options', EntityType::class, [
                "required" => false,
                'label' => false,
                'class' => PropertyOptions::class,
                'choice_label' => 'name',
                'multiple' => true
            ])
            ->add('city', TextType::class, [
                'required' => false
            ])
            ->add('distance', ChoiceType::class, [
                'required' => false,
                'multiple' => false,
                'placeholder' => false,
                'choices' => [
                    '10km'=> 10,
                    '25km' => 25,
                    '50km' => 50,
                    '100km' => 100,
                    '200km' => 200,
                ]
            ]) 
            ->add('lng', TextType::class, [
                'required' => false
            ])
            ->add('lat', TextType::class, [
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'get',
            'csrf_protection' => false
        ]);
    }

    // Permet d'avoir des params de rechercher propre
    public function getBlockPrefix()
    {
        return '';
    }
}
