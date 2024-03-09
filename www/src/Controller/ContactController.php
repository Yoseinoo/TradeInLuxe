<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Form\Model\ContactFormModel;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, MailerInterface $mailerInterface): Response
    {

        $formModel = new ContactFormModel();
        $form = $this->createForm(ContactFormType::class, $formModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            try {
                $email = (new TemplatedEmail())
                    ->to($formData->service->getEmail())
                    ->from($formData->email)
                    ->subject($formData->service->getSujet())
                    ->htmlTemplate('emails/contact.html.twig')
                    ->context(['data' => $formData]);


                $mailerInterface->send($email);

                $this->addFlash(
                    'success',
                    'Succès !|Votre email a bien été envoyé.|success'
                );
                return $this->redirectToRoute('app_contact');
            } catch (\Exception $e) {
                $this->addFlash(
                    'danger',
                    'Oops...|Impossible d\'envoyer votre email.|error'
                );
            }
        }
        return $this->render('contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}
