<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CardsController extends AbstractController
{
    #[Route('/card')]
    public function importCard(): Response
    {
        $server = $this->getParameter('kernel.project_dir');

        $cardsArr = unserialize(file_get_contents($server . "/storage/cards.inc"));
        
        return $this->render('card/index.html.twig', [
            'preparedArr' => $cardsArr,
        ]);
    }
}