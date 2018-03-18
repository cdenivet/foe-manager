<?php

namespace AppBundle\Event;

class AccountEvents
{

    /*
     * liste des événements sous forme de constantes
     *      valeur : identifiant unique
     */
    const CREATE = 'account.create';
    const DELETE = 'account.delete';
    const PASSWORD_FORGOT = 'account.forgot';

}