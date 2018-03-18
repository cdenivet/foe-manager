<?php

namespace AppBundle\Controller;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage.index")
     */
    public function indexAction(ManagerRegistry $doctrine, Request $request):Response
    {
        //Récupération de la locale dans la variable globale Request
        $locale = $request->getLocale();

        return $this->render('homepage/index.html.twig', [
        ]);
    }
}
