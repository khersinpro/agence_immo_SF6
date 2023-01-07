<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileUploader
{
    private $propertyImageDirectory;
    private $propertyImagePublicPath;
    private $slugger;


    public function __construct($propertyImageDirectory, $propertyImagePublicPath, SluggerInterface $slugger )
    {
        $this->propertyImageDirectory = $propertyImageDirectory;
        $this->propertyImagePublicPath = $propertyImagePublicPath;
        $this->slugger = $slugger;
    }

    public function uploadImage(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $fileName = $this->propertyImagePublicPath.'/'.$safeFilename.'-'.uniqid().'.'.$file->guessExtension();

        try {
            $file->move($this->propertyImageDirectory, $fileName);
        } catch (FileException $e) {
            throw new FileException("L'image n'a pas été enregistré", 1);
        }

        return $fileName;
    }
}