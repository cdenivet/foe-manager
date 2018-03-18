<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Gm;
use AppBundle\Entity\Level;
use AppBundle\Form\LevelType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class LevelController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     *
     * @Route("/level", name="admin.level.index")
     */
    public function index(ManagerRegistry $doctrine):Response
    {
        $repo = $doctrine->getRepository(Level::class);
        $results = $repo->findAll();
        return $this->render('admin/level/index.html.twig', [
            'results' => $results
        ]);
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param integer $IDGm
     * @return Response
     *
     * @Route("/level/gm/{$IDGm}", name="admin.level.gm.index", requirements={ "$IDGm" = "\d+" })
     */
    public function indexGm(ManagerRegistry $doctrine, int $IDGm):Response
    {

        return $this->render('admin/level/gm/index.html.twig', [
            'results' => $results
        ]);
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param integer $ID
     * @return Response
     *
     * @Route("/level/form", name="admin.level.form", defaults={ "ID" = 0 })
     * @Route("/level/form/update/{ID}", name="admin.level.form.update", requirements={ "ID" = "\d+" })
     */
    public function form(ManagerRegistry $doctrine, Request $request, int $ID):Response
    {
        $repo = $doctrine->getRepository(Level::class);

        //Instanciation de l'entité
        $LevelEntity = $ID != 0  ? $repo->find($ID) : new Level();

        $form = $this->createForm(LevelType::class, $LevelEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();

            // message flash
            $message = $ID ? 'Le niveau a été modifié !' : 'Le niveau a été créé !';
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('admin.level.index');
        }

        return $this->render('admin/level/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param integer $ID
     * @return Response
     *
     * @Route("/level/delete/{ID}", name="admin.level.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $ID):Response
    {
        $em = $doctrine->getManager();
        $repo = $doctrine->getRepository(Level::class);
        $productToDelete = $repo->find($ID);

        $em->remove($productToDelete);
        $em->flush();

        $this->addFlash('notice', 'Le niveau a été supprimé !');

        return $this->redirectToRoute('admin.gm.index');
    }
}
