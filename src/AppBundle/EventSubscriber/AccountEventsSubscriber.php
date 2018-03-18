<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Entity\User;
use AppBundle\Entity\UserToken;
use AppBundle\Event\AccountCreateEvent;
use AppBundle\Event\AccountEvents;
use AppBundle\Event\AccountForgotPasswordEvent;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AccountEventsSubscriber implements EventSubscriberInterface
{
    private $doctrine;
    private $mailer;
    private $twig;

    public function __construct(ManagerRegistry $doctrine, \Swift_Mailer $swift_Mailer, \Twig_Environment $twig)
    {
        $this->doctrine = $doctrine;
        $this->mailer = $swift_Mailer;
        $this->twig = $twig;
    }
    public static function getSubscribedEvents():array
    {
        /*
         * Retourne un tableau
         * Clé :  Evenement écouté
         * Valeur : Méthode exécuté dans le gestionnaire d'évènement
         */

        return [
            AccountEvents::CREATE => 'onAccountCreate',
            AccountEvents::PASSWORD_FORGOT => 'passwordForgot'
        ];
    }
    public function onAccountCreate(AccountCreateEvent $event)
    {
        $User = $event->getUser();
        $username = $User->getUsername();
        /*
         * Envoie d'un email
         */

        // Création du message
        $message = (new \Swift_Message('Bienvenue sur Website'))
            ->setFrom(['admin@website.com' => 'Christophe'])
            ->setTo([
                $User->getEmail() => $username
            ])
            ->setBody(
                $this->twig->render('emailing/account.create.html.twig', ['user' => $User]),
                'text/html'
            )
            ->addPart(
                $this->twig->render('emailing/account.create.txt.twig', ['user' => $User])
            )
        ;

        // Envoyer le message
        $this->mailer->send($message);

    }
    public function passwordForgot(AccountForgotPasswordEvent $event)
    {
        /*
         * si l'email existe dans la table User
         * si une demande n'a pas déjà été effectuée depuis moins d'un jour
         */
        $email = $event->getUserToken()->getUserEmail();
        $user_exist = $this->doctrine->getRepository(User::class)->findBy(['email' => $email]);
        $email_exist = $this->doctrine->getRepository(UserToken::class)->findBy(['userEmail' => $email]);

        dump($email_exist);
        dump($event->getUserToken()); exit();

    }
}