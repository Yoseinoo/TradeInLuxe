<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\InscriptionType;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{

    #[Route('/inscription', name: 'app_inscription')]
    public function inscription(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }
        
        $user = new User();
        $form = $this->createForm(InscriptionType::class, $user, [
            'action' => $this->generateUrl('app_inscription'),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $this->addFlash('success', 'Votre compte a bien été créé.');

            $userRepository->save($formData, true);

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('security/inscription.html.twig', [
            'form' => $form,
        ]);
    }
}
