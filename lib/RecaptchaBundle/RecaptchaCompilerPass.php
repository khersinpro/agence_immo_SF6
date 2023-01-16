<?php

namespace MyBundle\RecaptchaBundle;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RecaptchaCompilerPass implements CompilerPassInterface
{
    // Permet de verifié et de modifier des parametres dans le container
    public function process(ContainerBuilder $container)
    {
        // twig.form.resources defini a twig ou aller chercher les fichier twig des differents bundle
        if ($container->hasParameter('twig.form.resources')) {
            $resources = $container->getParameter('twig.form.resources') ?: [];
            // On ajoute dans la route de notre fichier twig pour le recaptcha bundle dans les ressours de twig
            // symfony console debug:twig pour voir les routes disponible
            array_push($resources, '@Recaptcha/fields.html.twig');
            // Puis on set la valeur 'twig.form.resources' avec la nouvelle valeur dans le container
            $container->setParameter('twig.form.resources', $resources);
        }
    }
}