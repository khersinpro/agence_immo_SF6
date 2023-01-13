<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use App\Entity\PropertyHeat;
use App\Entity\PropertyOptions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('title')
        ->add('description')
        ->add('surface')
        ->add('rooms')
        ->add('bedrooms')
        ->add('floor')
        ->add('price')
        ->add('heat', EntityType::class, [
            'class' => PropertyHeat::class,
            'choice_label' => 'name',
            'multiple' => false,
            'required' => true
        ])
        ->add('picturesArray', FileType::class, [
            'required' => false,
            'multiple' => true,
            'attr' => [
                'class' => 'form-control',
            ]
        ])
        ->add('options', EntityType::class, [
            'class' => PropertyOptions::class,
            'choice_label' => 'name',
            'multiple' => true,
            'required' => false,
        ])
        ->add('city')
        ->add('address')
        ->add('postal_code')
        ->add('sold')
        ->add('lat', HiddenType::class)
        ->add('lng', HiddenType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }
}
