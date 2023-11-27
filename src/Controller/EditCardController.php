<?php

namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\EditCardType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class EditCardController extends AbstractController
{


    #[Route('/card/edit/{id}')]
    public function form(Request $request, int $id): Response
    {
        $server = $this->getParameter('kernel.project_dir');
        $cardsArr = unserialize(file_get_contents($server . "/storage/cards.inc"));
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(EditCardType::class, null, ['empty_data' => $cardsArr[$id]]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $editedCard = $form->getData();
            $cardsArr[(int) $id] = $editedCard;
            
            try {
                file_put_contents($server . "/storage/cards.inc", serialize($cardsArr));
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            };

            return $this->redirect('/card');
        }
        return $this->render('card/edit.html.twig', [
            'form' => $form,
        ]);
    }
}