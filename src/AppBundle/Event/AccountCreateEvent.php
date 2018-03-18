<?php

namespace AppBundle\Event;

use AppBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class AccountCreateEvent extends Event
{
    /*
     * On met ici toutes les propriétés dont on a besoin afin de pouvoir utiliser les getters et setters
     */
    private $user;

    public function getUser():User
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }
}