<?php

namespace MyBundle\RecaptchaBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    // Permet de definir l'arbre qui definira la configuration du fichier de configuration recaptcha.yaml 
    // doc => https://symfony.com/doc/current/components/config/definition.html
    public function getConfigTreeBuilder()
    {

        // La convention de nommage du fichier de configuration .yaml est en snakecase
        // Elle conrespond au nom du bundle sans le mot bundle ex: RecaptchaBundle => recaptcha
        // Le threebuilder ira dans les fichier de configuration yaml et recupérera celui indiqué dans ses params
        $treeBuilder = new TreeBuilder('recaptcha');
        $rootNode = $treeBuilder->getRootNode();
        //Création de l'arbre de configuration
        $rootNode
            ->children()
            ->scalarNode('key')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
            ->scalarNode('secret')
            ->isRequired()
            ->cannotBeEmpty()
            ->end()
        ->end();  
        
        // Une fois la configuration établi, on retourne le treebuilder
        return $treeBuilder;
    }    
}