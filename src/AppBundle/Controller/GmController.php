<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Gm;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class GmController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param string $slugGm
     * @return Response
     *
     * @Route("/gm/{slugGm}", name="gm.index")
     */
    public function indexAction(ManagerRegistry $doctrine, Request $request, string $slugGm):Response
    {
        //Récupération de la locale dans la variable globale Request
        $locale = $request->getLocale();

        $GmRepo = $doctrine->getRepository(Gm::class);
        $idGm = $GmRepo->getGmIdBySlugByLocale($slugGm, $locale);
        $Gm = $doctrine->getManager()->find(Gm::class, $idGm );
        return $this->render('gm/index.html.twig', [
            'era' => $Gm->getEra(),
            'gm' => $Gm,
            'levels' => $Gm->getLevels()
        ]);
    }
}
