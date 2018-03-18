<?php

namespace AppBundle\Event;

use AppBundle\Entity\UserToken;
use Symfony\Component\EventDispatcher\Event;

class AccountForgotPasswordEvent extends Event
{
    /*
     * l'événement sert d'interface entre le déclencheur et le souscripteur
     * */

    private $userToken;


    public function getUserToken():UserToken
    {
        return $this->userToken;
    }


    public function setUserToken(UserToken $userToken)
    {
        $this->userToken = $userToken;
    }


}