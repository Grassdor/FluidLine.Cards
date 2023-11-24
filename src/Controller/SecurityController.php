<?php

namespace App\Controller;

use App\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    #[Route(path: '/register', name: "app_register")]
    public function register(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $preparedData = [
                $data->getUsername() => ["password" => $data->getPassword(), "roles" => implode(", ", $data->getRoles())]
            ];
            
            $server = $this->getParameter('kernel.project_dir');
            file_put_contents($server . "/config/packages/security.yaml", Yaml::dump($preparedData, 1));
            return $this->redirect('/card');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form,
        ]);
    }
}

