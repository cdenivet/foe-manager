<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Entity\UserToken;
use AppBundle\Event\AccountCreateEvent;
use AppBundle\Event\AccountEvents;
use AppBundle\Event\AccountForgotPasswordEvent;
use AppBundle\Form\UserTokenType;
use AppBundle\Form\UserType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;


class AccountController extends Controller
{
    /**
     * @Route("/signup", name="account.signup")
     */
    public function signUp(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, EventDispatcherInterface $eventDispatcher):Response
    {
        //Instanciation de l'entité
        $UserEntity = new User();
        $form = $this->createForm(UserType::class, $UserEntity); //Nécessite le namespace de ContactType

        //Récupération des données dans la requête
        $form->handleRequest($request);

        //Formulaire valide
        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            //Récupération des données sous la forme d'entité
            $data = $form->getData();
            //Mise en file d'attente de la requete
            $em->persist($data);
            //Execution de la requete
            $em->flush();

            $message = $translator->trans('flash_message.new_user');
            $this->addFlash('notice', $message);

            //Déclenchement d'un évenement (envoie de mail)
            $event = new AccountCreateEvent();
            $event->setUser($data);

            $eventDispatcher->dispatch(AccountEvents::CREATE,$event);

            //Redirection vers la liste des message de contact
            return $this->redirectToRoute('security.login');
        }

        return $this->render('account/signUp.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/password-forgot", name="account.password.forgot")
     */
    public function passwordForgotAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, EventDispatcherInterface $dispatcher):Response
    {
        // création d'un formulaire
        $entity = new UserToken();
        $type = UserTokenType::class;

        $form = $this->createForm($type, $entity);
        $form->handleRequest($request);

        // formulaire valide
        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            //On vérifie que l'email n'est pas deja dans la table en bdd

            $email_exist = $doctrine->getRepository(UserToken::class)->findOneBy(['userEmail' => $entity->getUserEmail()]);
            if($email_exist){
                $DateTime = new \DateTime();
                $diff = $DateTime->diff($email_exist->getExpirationDate());

                if($DateTime < $email_exist->getExpirationDate()){
                    $this->addFlash('notice', $translator->trans('flash_message.password_token_already_sent'));
                    return $this->redirectToRoute('account.password.forgot');
                }else{
                    //Suppression de la table afin de pouvoir faire une nouvelle insertion
                }
            }
            //dump($email_exist); exit();
            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();

            // événement
            $event = new AccountForgotPasswordEvent();
            $event->setUserToken($data);

            // déclencher l'événement AccountEvents::PASSWORD_FORGOT
            $dispatcher->dispatch(AccountEvents::PASSWORD_FORGOT, $event);

            // message flash
            $this->addFlash('notice', $translator->trans('flash_message.password_token_send'));

            // redirection
            return $this->redirectToRoute('security.login');
        }

        return $this->render('account/password.forgot.html.twig',[
            'form' => $form->createView()
        ]);
    }
}
