<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class RecetteController extends AbstractController
{
    #[Route('/recettes', name: 'freshmatch_recette', methods: ['GET'])]
    public function list():void {}
    #[Route('/recettes/read', name: 'freshmatch_recette_read', methods: ['GET'])]
    public function read():void {}

    #[Route('/recettes/créer', name: 'freshmatch_recette_create', methods: ['GET'])]
    public function create():void {}

    #[Route('/recettes/modifier', name: 'freshmatch_recette_update', methods: ['GET'])]
    public function update():void {}
    public function delete():void {}


}

?>