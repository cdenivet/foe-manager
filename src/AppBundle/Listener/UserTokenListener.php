<?php

namespace AppBundle\Listener;

use AppBundle\Entity\UserToken;
use AppBundle\Service\GenerateToken;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class UserTokenListener
{
    /*
     * injecter un service
     *      - créer une propriété
     *      - créer un constructeur
     * */
    private $generateToken;

    public function __construct(GenerateToken $generateToken)
    {
        $this->generateToken = $generateToken;
    }

    /*
     * le nom des méthodes doivent reprendre le nom de l'événement écouté
     * paramètres:
     *      - instance de l'entité écouté
     *      - argument différent selon l'événement écouté
     * */
     public function prePersist(UserToken $userToken, LifecycleEventArgs $args){
        // Génération du token
         $token = $this->generateToken->generateToken();
         $DateTime = new \DateTime('+1 day');

         // mise à jour token
         $userToken->setToken($token);
         $userToken->setExpirationDate($DateTime);
     }

}





















