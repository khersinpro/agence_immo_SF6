<?php 

namespace MyBundle\RecaptchaBundle\Constraints;

use Symfony\Component\Validator\Constraint;

class Recaptcha extends Constraint
{
    // Message a afficher quand un captcha invalide est soumis
    public  $recaptchaErrorMessage = 'Invalid captcha';
}