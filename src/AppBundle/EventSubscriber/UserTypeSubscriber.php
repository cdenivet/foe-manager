<?php

namespace AppBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\RequestStack;

class UserTypeSubscriber implements EventSubscriberInterface
{

    private $request;

    public function __construct(RequestStack $request)
    {
        $this->request = $request->getMasterRequest();
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData'
        ];
    }

    public function preSetData(FormEvent $event)
    {
        // r�cup�rer la route
        $route = $this->request->get('_route');

        // r�cup�ration de la saisie
        $data = $event->getData();

        // formulaire
        $form = $event->getForm();

        // tester la route
        if($route === 'profile.manage.index'){
            $form->remove('username');
            $form->remove('password');
            $form->remove('email');
        }

    }

}
