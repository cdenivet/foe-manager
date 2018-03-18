<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Era;
use AppBundle\Form\EraType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class EraController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     *
     * @Route("/era", name="admin.era.index")
     */
    public function index(ManagerRegistry $doctrine):Response
    {
        $repo = $doctrine->getRepository(Era::class);
        $results = $repo->findAll();
        return $this->render('admin/era/index.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param integer $ID
     * @return Response
     *
     * @Route("/era/form", name="admin.era.form", defaults={ "ID" = 0 })
     * @Route("/era/form/update/{ID}", name="admin.era.form.update", requirements={ "ID" = "\d+" })
     */
    public function form(ManagerRegistry $doctrine, Request $request, int $ID):Response
    {
        $repo = $doctrine->getRepository(Era::class);

        //Instanciation de l'entité
        $EraEntity = $ID != 0  ? $repo->find($ID) : new Era();

        $form = $this->createForm(EraType::class, $EraEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();

            // message flash
            $message = $ID ? 'L\'ère a été modifié !' : 'L\'ère a été créé !';
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('admin.era.index');
        }

        return $this->render('admin/era/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param integer $ID
     * @return Response
     *
     * @Route("/era/delete/{ID}", name="admin.era.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $ID):Response
    {
        $em = $doctrine->getManager();
        $repo = $doctrine->getRepository(Era::class);
        $eraToDelete = $repo->find($ID);
        /*
         * Rendre impossible la suppression s'il y a des produits associés à la catégorie
         *
        if( !empty( $repo->getHowMuchProductsByCategory($ID) ) ){
            $this->addFlash('notice-danger', 'La catégorie contient des produits, elle ne peut pas être supprimé !');
            return $this->redirectToRoute('admin.category.index');
        }
        */
        $em->remove($eraToDelete);
        $em->flush();

        $this->addFlash('notice', 'L\'ère a été supprimé !');

        return $this->redirectToRoute('admin.era.index');
    }
}
