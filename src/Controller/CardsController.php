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
        

        $fp = file_get_contents("../public/uploads/cards.inc", "r");
        $objArr = preg_split("/\n/", $fp);
        $preparedArr = [];
        foreach ($objArr as $item) {
            if ($item !== "") {
                $preparedArr[] = unserialize($item);
            }
            
        }
        return $this->render('card.html.twig', [
            'preparedArr' => $preparedArr,
        ]);
    }
}