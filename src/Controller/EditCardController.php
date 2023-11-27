<?php

namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\EditCardType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use App\Entity\NewCard;

class EditCardController extends AbstractController
{
    protected int $id = 1;

    #[Route('/card/edit/{id}')]
    public function form(Request $request, int $id): Response
    {

        $card = new NewCard();
        $card->setCardName('RazDvaTri');
            
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(EditCardType::class, null, ['empty_data' => $card]);
        // dump($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newCard = $form->getData();
            $serializedCard = serialize($newCard);
            
            $fs = new Filesystem();
            $server = $this->getParameter('kernel.project_dir');
            try {
                $fs->appendToFile($server . "/storage/cards.inc", $serializedCard . "\n");
                // dd($fs);
            } catch (IOExceptionInterface $exception) {
                echo "An error occurred while creating your directory at " . $exception->getPath();
            };

            return $this->redirect('/card');
        }
        return $this->render('card/edit.html.twig', [
            'form' => $form,
            'card' => $card,
        ]);
    }
}