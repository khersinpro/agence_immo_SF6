<?php

namespace App\EventListener;

use App\Entity\Property;
use App\Entity\PropertyPicture;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\Filesystem\Filesystem;

class DeletePropertyImage
{
    private $fs;
    private $propertyImageDirectory;
    private $cacheManager;
    private $propertyImagePublicPath;

    public function __construct($propertyImageDirectory, CacheManager $cacheManager, $propertyImagePublicPath)
    {
        $this->fs = new Filesystem();
        $this->propertyImageDirectory = $propertyImageDirectory;
        $this->cacheManager = $cacheManager;
        $this->propertyImagePublicPath = $propertyImagePublicPath;
    }

    // Delete Thumbnail and native image after deleting property
    public function postRemove(LifecycleEventArgs $args)
    {
        /**
         * @var PropertyPicture
         */
        $property = $args->getObject();

        if (!$property instanceof PropertyPicture) {
           return;
        }

        $filename = pathinfo($property->getPicture(), PATHINFO_BASENAME);
        $this->fs->remove($this->propertyImageDirectory."/".$filename);
        $this->cacheManager->remove($this->propertyImagePublicPath.'/'.$filename, [
            'my_thumb', 
            'medium'
        ]);
    }

    
    // public function preUpdate(PreUpdateEventArgs $args)
    // {
    //     dd("aarrivé");
    //     if ($args->hasChangedField('thumb') && $args->getOldValue('thumb')) {
    //         $filename = pathinfo($args->getOldValue('thumb'), PATHINFO_BASENAME);

    //         $this->fs->remove($this->propertyImageDirectory."/".$filename);
    //         $this->cacheManager->remove($this->propertyImagePublicPath.'/'.$filename, [
    //             'my_thumb', 
    //             'medium'
    //         ]);
    //     }
    // }
}