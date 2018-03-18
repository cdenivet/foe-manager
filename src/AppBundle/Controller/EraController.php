<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Era;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class EraController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param string $slugEra
     * @return Response
     *
     * @Route("/era/{slugEra}", name="era.index")
     */
    public function indexAction(ManagerRegistry $doctrine, Request $request, string $slugEra):Response
    {
        //Récupération de la locale dans la variable globale Request
        $locale = $request->getLocale();

        $EraRepo = $doctrine->getRepository(Era::class);
        $eraName = $EraRepo->getEraBySlugByLocale($slugEra, $locale);
        $gms = $EraRepo->getAllGmByEraByLocale($slugEra, $locale);

        return $this->render('era/index.html.twig', [
            'era' => $eraName,
            'gms' => $gms
        ]);
    }
}
