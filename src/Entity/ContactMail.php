<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Property;

class ContactMail
{

    #[Assert\NotBlank(message: 'Ce champ doit être remplis.')]
    #[Assert\Length(min: 2, max: 25,
        minMessage: 'Ce champ doit contenir au minimum {{ limit }} caractères.',
        maxMessage: 'Ce champ ne doit pas contenir plus de {{ limit }} caractères.'
    )]
    private $firstname;
    
    #[Assert\NotBlank(message: 'Ce champ doit être remplis.')]
    #[Assert\Length(min: 2, max: 25,
        minMessage: 'Ce champ doit contenir au minimum {{ limit }} caractères.',
        maxMessage: 'Ce champ ne doit pas contenir plus de {{ limit }} caractères.'
    )]
    private $lastname;
    
    #[Assert\NotBlank(message: 'Ce champ doit être remplis.')]
    #[Assert\Email(message: 'La valeur suivante {{ value }} n\'est pas un email valide.')]
    private $email;
    
    #[Assert\NotBlank(message: 'Ce champ doit être remplis.')]
    #[Assert\Regex(pattern: '/^[0-9]{10}/', message: 'Votre numéro de téléphone est invalide.')]
    private $phone;
    
    #[Assert\NotBlank(message: 'Ce champ doit être remplis.')]
    #[Assert\Length(min: 20, max: 250,
        minMessage: 'Ce champ doit contenir au minimum {{ limit }} caractères.',
        maxMessage: 'Ce champ ne doit pas contenir plus de {{ limit }} caractères.'
    )]
    private $message;

    /**
     * @var Property|null
     */
    private $property;

    public function setFirstName(string $firstname): void
    {
        $this->firstname = $firstname;
    }
    
    public function getFirstName(): ?string
    { 
        return $this->firstname;
    }
    
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }
    
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }
    
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
    
    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setProperty(Property $property): void
    {
        $this->property = $property;
    }
    
    public function getProperty(): Property
    {
        return $this->property;
    }
}