<?php

namespace AppBundle\Controller\Profile;

use AppBundle\Form\UserType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/profile")
 */
class ManageController extends Controller
{
    /**
     * @Route("/manage", name="profile.manage.index")
     */
    public function indexAction(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, EventDispatcherInterface $dispatcher):Response
    {
        $user = $this->getUser();

        $type = UserType::class;

        $form = $this->createForm($type, $user);
        $form->handleRequest($request);

        // formulaire valide
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();

            //$dispatcher->dispatch(FormEvents::PRE_SET_DATA, $event);

            // message flash
            $this->addFlash('notice', $translator->trans('flash_message.profile.completed'));
            return $this->redirectToRoute('profile.homepage.index');
        }
        return $this->render('profile/manage/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}