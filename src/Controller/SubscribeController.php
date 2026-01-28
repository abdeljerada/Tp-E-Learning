<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\SubscribeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SubscribeController extends AbstractController
{
    public function showForm(): Response
    {
        $form = $this->createForm(SubscribeType::class);

        return $this->render(
            'subscribe/index.html.twig',
            ['form' => $form->createView()]
        );
    }

    #[Route(path: '/subscribe', name: 'app_subscribe', methods: ['POST'])]
    public function proceed(Request $request): Response
    {
        $form = $this->createForm(SubscribeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $email = $data['email'];
            
            $this->addFlash('success', 'Merci pour votre inscription à notre newsletter !');
            
            return $this->redirectToRoute('app_page');
        }

        $this->addFlash('error', 'Veuillez entrer une adresse email valide.');
        return $this->redirectToRoute('app_page');
    }
}
