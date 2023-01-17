<?php

namespace MyBundle\RecaptchaBundle\Constraints;

use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class RecaptchaValidator extends ConstraintValidator
{
    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var ReCaptcha
     */
    private $recaptcha;

    // On ajoute le Requeststack pour recuperer le code du captcha ajouté par google dans la requete
    // Il faut au préalable ajouté le RequestStack comme composant injectable dans la config.yaml du bundle
    public function __construct(RequestStack $requestStack, ReCaptcha $recaptcha)
    {
        $this->requestStack = $requestStack;
        $this->recaptcha = $recaptcha;
    }

    public function validate(mixed $value, Constraint $constraint)
    {
        // Récupération du code ajouté a la requette par google
        $request  = $this->requestStack->getMainRequest();
        $recaptchaResponse = $request->get('g-recaptcha-response');

        // S'il n'y a pas de $recaptchaResponse, on envoie un nouvelle violation de contrainte
        if (empty($recaptchaResponse)) {
            return $this->context->buildViolation($constraint->recaptchaErrorMessage)->addViolation();
        }

        // Controle du $recaptchaResponse 
        $response = $this->recaptcha
            ->setExpectedHostname($request->getHost().'fdsffsd')
            ->verify($recaptchaResponse, $request->getClientIp());

        // Si ce n'est pas valide, on envoie un nouvelle violation de contrainte
        if (!$response->isSuccess()) {
            return $this->context->buildViolation($constraint->recaptchaErrorMessage)->addViolation();
        }
    }

    
}
