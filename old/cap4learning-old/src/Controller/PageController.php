<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Mailer\Mailer;
use App\Manager\ContactManager;
use App\Manager\PageManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/contact", name="page_contact")
     */
    public function contact(Request $request, Mailer $mailer, ContactManager $contactManager): Response
    {
        $contact = new Contact();
        $contact->setType(Contact::CONTACT_OTHER);

        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->addFlash('success', 'Your message has been successfully sent !');
            $mailer->sendConfirmationContact($contact, 'Contact' );
            $contact->setConversionPage('Contact');
            $contactManager->save($contact);
            return $this->redirect($request->getUri());
        }

        return $this->render('page/contact.html.twig', [
            'form' => $contactForm->createView()
        ]);
    }

    /**
     * @Route({
     *     "en": "/tailor-made-training",
     *     "fr": "/formation-sur-mesure"
     * }, name="page_surmesure")
     */
    public function surmesure(Request $request, Mailer $mailer, ContactManager $contactManager): Response
    {
        $contact = new Contact();
        $contact->setType(Contact::CONTACT_OTHER);
        $contactForm = $this->createForm(ContactType::class, $contact);
        $contactForm->handleRequest($request);
        if ($contactForm->isSubmitted() && $contactForm->isValid()) {
            $this->addFlash('success', 'Your message has been successfully sent !');
            $mailer->sendConfirmationContact($contact);
            $contact->setConversionPage('Formation sur mesure');
            $contactManager->save($contact);
            return $this->redirect($request->getUri());
        }

        return $this->render('page/tailormade.html.twig', [
            'form' => $contactForm->createView()
        ]);
    }

    /**
     * @Route("/{slug}", name="page_detail")
     */
    public function index($slug, Request $request, PageManager $pageManager): Response
    {
        $page = $pageManager->findBySlug($slug, $request->getLocale());

        if (!$page) {
            throw new NotFoundHttpException('This page doesnt exist');
        }

        return $this->render('page/index.html.twig', [
            'page' => $page,
        ]);
    }
}
