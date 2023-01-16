<?php

namespace MyBundle\RecaptchaBundle\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


// Tous les types destinés aux composant de formulaire extends de AbstractType
class RecaptchaSubmitType extends AbstractType
{   
    private $key;
    private $secret;

    public function __construct($key, $secret)
    {
        $this->key = $key;
        $this->secret = $secret;
    }

    // Definition des options de configuration
    public function configureOptions(OptionsResolver $resolver)
    {
        // Definition de mapped a false pour qu'il ne sois pas relié a l'entité du formulaire
        $resolver->setDefaults([
            'mapped' => false
        ]);
    }

    // Cette fonction permet de set les dirrentes options du Recaptcha
    // Nous metton le label a false et nous ajouter le text du label defini dans le label 
    // par l'utilisateur dans le text du button
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['label'] = false;
        $view->vars['button'] = $options['label'];
        $view->vars['type'] = 'submit';
        $view->vars['key'] = $this->key;
    }

    // Permet de finir un prefix pour que nos vues puisse savoir quel outil rendre
    // Par exemple, si on return 'submit' la vue decidera automatiquement de rendre un btn de type submit
    public function getBlockPrefix()
    {
        return 'recaptcha_submit';
    }

    // Precise quel Type est parent de notre class, notre class heritera des memes options que le type choisis
    public function getParent()
    {
        return TextType::class;
    }

}

