<?php

namespace App\Mailer;

use App\Entity\Contact;
use Nucleos\UserBundle\Mailer\Mail\ResettingMail;
use Nucleos\UserBundle\Mailer\MailerInterface;
use Nucleos\UserBundle\Model\UserInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\VarDumper\VarDumper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Environment;

class Mailer implements MailerInterface
{
    protected $mailer;
    protected $templating;
    protected $params;
    protected $translator;
    protected $router;

    public function __construct(\Swift_Mailer $mailer, TranslatorInterface $translator, Environment $templating, ParameterBagInterface $params, UrlGeneratorInterface $router)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->params = $params;
        $this->translator = $translator;
        $this->router = $router;
    }

    public function sendConfirmationContact(Contact $contact, string $page = '') {
        $message = (new \Swift_Message('New contact'))
            ->setTo($this->params->get('MAILER_RECEIVER'))
            ->setFrom($this->params->get('MAILER_SENDER'))
            ->setBody(
                $this->templating->render(
                    'emails/contact.html.twig',
                    [
                        'page' => $page,
                        'contact' => $contact,
                    ]
                ),
                'text/html'
            )
        ;

        $this->mailer->send($message);
    }

    public function sendResettingEmailMessage(UserInterface $user): void
    {
        $url  = $this->router->generate('nucleos_user_resetting_reset', [
            'token' => $user->getConfirmationToken(),
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        $mail = (new \Swift_Message('Cap4Learning: Réinitialisation du mot de passe'))
            ->setTo($user->getEmail())
            ->setFrom($this->params->get('MAILER_SENDER'))
            ->setBody(
                $this->templating->render(
                    'emails/reset.html.twig',
                    [
                        'url' => $url,
                        'user' => $user,
                    ]
                ),
                'text/html'
            )
        ;

        VarDumper::dump($user);

        $this->mailer->send($mail);
    }
}