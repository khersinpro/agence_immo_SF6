<?php

namespace App\Service;

use App\Entity\ContactMail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;


class MailManager
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function sendPropertyEmailContact(ContactMail $contact)
    {
        $email = (new TemplatedEmail())
            ->from('noreply@monagence.fr')
            ->to('contact@monagence.fr')
            ->replyTo($contact->getEmail())
            ->subject('Contact pour l\'annonce : '. $contact->getProperty()->getTitle())
            ->htmlTemplate('/email/property_contact/property_contact.html.twig')
            ->context(['contact' => $contact])
        ;
        
        $this->mailer->send($email);
    }
}
