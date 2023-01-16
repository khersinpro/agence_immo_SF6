<?php

namespace MyBundle\RecaptchaBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class RecaptchaBundle extends Bundle
{
    // Permet de modifier le container avant qu'il ne sois initialisé
    // Afin d'y ajouter des paramettres avec le compilerPass
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new RecaptchaCompilerPass());
    }
}