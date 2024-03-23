<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\EmailVerifier;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Symfony\Component\Mime\Address;
use App\Security\AppUserAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier, private UserRepository $userRepository)
    {
    }
    
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_accueil');
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $userRepository->save($formData, true);

            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('no-reply@tradeinluxe.fr', 'Trade In Luxe'))
                    ->to($user->getEmail())
                    ->subject('Merci de confirmer votre email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            $this->addFlash(
                'success',
                'Succès !|Votre compte a bien été créé. Merci de confirmer votre email.|success'
            );

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserAuthenticatorInterface $userAuthenticator, AppUserAuthenticator $authenticator): Response
    {

        try {
            $user = $this->userRepository->find($request->query->get('id'));

            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {

            $this->addFlash('danger', 'Oops...|'.$translator->trans($exception->getReason(), [], 'VerifyEmailBundle').'|error');

            return $this->redirectToRoute('app_register');
        }

        $this->addFlash(
                'success',
                'Succès !|Votre email a bien été confirmé.|success'
            );

        return $userAuthenticator->authenticateUser(
                $user,
                $authenticator,
                $request
            );
    }

}
