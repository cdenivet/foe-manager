<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Gm;
use AppBundle\Form\GmType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class GmController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     *
     * @Route("/gm", name="admin.gm.index")
     */
    public function index(ManagerRegistry $doctrine):Response
    {
        $repo = $doctrine->getRepository(Gm::class);
        $results = $repo->findAll();
        return $this->render('admin/gm/index.html.twig', [
            'results' => $results
        ]);
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param integer $ID
     * @return Response
     *
     * @Route("/gm/form", name="admin.gm.form", defaults={ "ID" = 0 })
     * @Route("/gm/form/update/{ID}", name="admin.gm.form.update", requirements={ "ID" = "\d+" })
     */
    public function form(ManagerRegistry $doctrine, Request $request, int $ID):Response
    {
        $repo = $doctrine->getRepository(Gm::class);

        //Instanciation de l'entité
        $GMEntity = $ID != 0  ? $repo->find($ID) : new Gm();

        $form = $this->createForm(GmType::class, $GMEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            //Déplacement du fichier uploadé dans le bon dossier
            $file = $form['image']->getData();
            if($file){
                $filename = $file->getClientOriginalName();
                $file->move('img/gm', $filename);
            }else{
                $filename ='no-foto.png';
            }

            if(!empty($oldImg) && $oldImg != 'no-foto.png'){
                if( file_exists ( "img/gm/$oldImg"))
                    unlink( "img/gm/$oldImg" ) ;
            }

            $data->setImage($filename);
            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();


            // message flash
            $message = $ID ? 'Le GM a été modifié !' : 'Le GM a été créé !';
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('admin.gm.index');
        }

        return $this->render('admin/gm/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param integer $ID
     * @return Response
     *
     * @Route("/gm/delete/{ID}", name="admin.gm.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $ID):Response
    {
        $em = $doctrine->getManager();
        $repo = $doctrine->getRepository(Gm::class);
        $productToDelete = $repo->find($ID);
        /*
         * Rendre impossible la suppression s'il y a des produits associés à la catégorie
         *
        if( !empty( $repo->getHowMuchProductsByCategory($ID) ) ){
            $this->addFlash('notice-danger', 'La catégorie contient des produits, elle ne peut pas être supprimé !');
            return $this->redirectToRoute('admin.category.index');
        }
        */
        $em->remove($productToDelete);
        $em->flush();

        $this->addFlash('notice', 'Le GM a été supprimé !');

        return $this->redirectToRoute('admin.gm.index');
    }
}
