<?php

namespace App\Controller;

use App\Entity\NewCard;
use App\Form\Type\EditCardType;
use App\Form\Type\NewCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class CardController extends AbstractController
{
    #[Route('/card', name: 'app_card')]
    public function viewCard(): Response
    {
        $storage = $this->getParameter('storage');

        $cards = unserialize(file_get_contents($storage ."cards.inc"));

        return $this->render('card/index.html.twig', [
            'preparedArr' => $cards,
        ]);
    }

    #[Route('/import/cards', name: 'app_import_cards')]
    public function importCards() : JsonResponse
    {
        $storage = $this->getParameter('storage');

        $json = file_get_contents($storage . "cards.json");
        $cards = json_decode($json, true);

        $newCards = [];

        foreach ($cards as $card) {
            $new = new NewCard();
            $new->setCardHost($card['cardHost']);
            $new->setCardId(uniqid());
            $new->setCardLink($card['cardLink']);
            $new->setCardName($card['cardName']);

            $newCards[] = $new;
        }

        file_put_contents($storage . "cards.inc", serialize($newCards));

        return new JsonResponse();
    }

    #[Route('/card/edit/{id}', name: 'app_card_edit_id')]
    public function cardEdit(Request $request, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $storage = $this->getParameter('storage');

        $cardsArr = unserialize(file_get_contents($storage . "cards.inc"));

        $form = $this->createForm(EditCardType::class, null, ['empty_data' => $cardsArr[$id]]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $editedCard = $form->getData();
            $cardsArr[$id] = $editedCard;

            try {
                file_put_contents($storage . "cards.inc", serialize($cardsArr));

            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            };

            return $this->redirect('/card');
        }

        return $this->render('card/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/card/new')]
    public function cardCreate(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $storage = $this->getParameter('storage');

        $cardsArr = unserialize(file_get_contents($storage . "cards.inc"));

        $form = $this->createForm(NewCardType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newCard = $form->getData();
            $cardsArr[] = $newCard;

            try {
                file_put_contents($storage . "cards.inc", serialize($cardsArr));

            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            }

            return $this->redirect('/card');
        }
        return $this->render('card/new.html.twig', [
            'form' => $form,
        ]);
    }
}
