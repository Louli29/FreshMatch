<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/politique-de-confidentialite', name: 'app_privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('pages/privacy_policy.html.twig');
    }

    #[Route('/conditions-utilisation', name: 'app_terms_conditions')]
    public function termsConditions(): Response
    {
        return $this->render('pages/terms_conditions.html.twig');
    }
}
