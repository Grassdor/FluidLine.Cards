<?php

namespace App\Controller;



use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\Type\NewCardType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class NewCardController extends AbstractController
{
    #[Route('/card/new')]
    public function form(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $fp = file_get_contents($server . "/storage/cards.inc", "r");
        $preparedFp = unserialize($fp);
        $form = $this->createForm(NewCardType::class);
        // dump($form);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newCard = $form->getData();
            $preparedFp[] = $newCard;
            
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
        return $this->render('card/new.html.twig', [
            'form' => $form,
        ]);
    }
}