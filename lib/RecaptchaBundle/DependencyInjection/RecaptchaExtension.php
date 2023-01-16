<?php

namespace MyBundle\RecaptchaBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class RecaptchaExtension extends Extension
{
    // Cette fonction va permettre de recupérer les données des differents fichier de configuration yaml
    public function load(array $configs, ContainerBuilder $container)
    {
        // Le Yaml fileLoader permet de mettre a disposition les fichier de config qu'on lui a defini
        // afin de passer des parametres directement dans certaine partie du service
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');
        // On créer l'arbre de configuration yaml du bundle
        $configuration = new Configuration();
        // On recupére tous les parametres des configuration passé en parametre
        $config = $this->processConfiguration($configuration, $configs);

        // On peux passer dans les params du container les paramettres recupérer ci dessus
        $container->setParameter('recaptcha.key', $config['key']);
        $container->setParameter('recaptcha.secret', $config['secret']);

    }
}