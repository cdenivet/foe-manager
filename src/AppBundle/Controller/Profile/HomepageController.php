<?php

namespace AppBundle\Controller\Profile;

use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/profile")
 */
class HomepageController extends Controller
{
    /**
     * @Route("/", name="profile.homepage.index")
     */
    public function index(ManagerRegistry $doctrine, Request $request):Response
    {

        return $this->render('profile/base.html.twig', [
        ]);
    }
}
