<?php

namespace AppBundle\Listener;

use AppBundle\Entity\User;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Mapping\PrePersist;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

class UserListener
{
    /*
     * injecter un service
     *      - créer une propriété
     *      - créer un constructeur
     * */
    private $encoder;

    public function __construct(UserPasswordEncoder $encoder)
    {
        $this->encoder = $encoder;
    }

    /*
     * le nom des méthodes doivent reprendre le nom de l'événement écouté
     * paramètres:
     *      - instance de l'entité écouté
     *      - argument différent selon l'événement écouté
     * */
    /**
     * @PrePersist
     */
    public function prePersist(User $user, LifecycleEventArgs $args) {
        $password = $user->getPassword();
        $encodedPassword = $this->encoder->encodePassword($user, $password);
        $user->setPassword($encodedPassword);
    }
}
