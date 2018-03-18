<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Era;
use AppBundle\Entity\Gm;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\RequestStack;

class Extension extends \Twig_Extension
{

    private $doctrine;
    private $twig;
    private $request;

    public function __construct(ManagerRegistry $doctrine, \Twig_Environment $twig, RequestStack $request)
    {
        $this->doctrine = $doctrine;
        $this->twig = $twig;
        $this->request = $request->getMasterRequest();
    }
    public function getFunctions():array
    {
        return [
            new \Twig_SimpleFunction('render_menu', [$this, 'renderMenu']),
        ];
    }
    // Mes nouvelles fonction
    public function renderMenu()
    {
        $EraRepo = $this->doctrine->getRepository(Era::class);
        $GmRepo = $this->doctrine->getRepository(Gm::class);
        $locale = $this->request->getLocale();
        return $this->twig->render('inc/nav.html.twig', [
            'eras' => $EraRepo->getAllEraByLocale($locale),
            'gms' => $GmRepo->getAllGmByLocale($locale),
        ]);
    }
}