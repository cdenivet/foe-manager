<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Doctrine\Common\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/admin")
 */
class UserController extends Controller
{
    /**
     * @param ManagerRegistry $doctrine
     * @return Response
     *
     * @Route("/user", name="admin.user.index")
     */
    public function index(ManagerRegistry $doctrine):Response
    {
        $repo = $doctrine->getRepository(User::class);
        $results = $repo->findAll();
        return $this->render('admin/user/index.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @param integer $ID
     * @return Response
     *
     * @Route("/user/form", name="admin.user.form", defaults={ "ID" = 0 })
     * @Route("/user/form/update/{ID}", name="admin.user.form.update", requirements={ "ID" = "\d+" })
     */
    public function form(ManagerRegistry $doctrine, Request $request, int $ID):Response
    {
        $repo = $doctrine->getRepository(User::class);

        //Instanciation de l'entité
        $EraEntity = $ID != 0  ? $repo->find($ID) : new Era();

        $form = $this->createForm(UserType::class, $EraEntity);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $em = $doctrine->getManager();
            $em->persist($data);
            $em->flush();

            // message flash
            $message = $ID ? 'L\'utilisateur a été modifié !' : 'L\'utilisateur a été créé !';
            $this->addFlash('notice', $message);

            return $this->redirectToRoute('admin.user.index');
        }

        return $this->render('admin/user/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ManagerRegistry $doctrine
     * @param integer $ID
     * @return Response
     *
     * @Route("/user/delete/{ID}", name="admin.user.delete")
     */
    public function delete(ManagerRegistry $doctrine, int $ID):Response
    {
        $em = $doctrine->getManager();
        $repo = $doctrine->getRepository(User::class);
        $userToDelete = $repo->find($ID);
        /*
         * Rendre impossible la suppression s'il y a des produits associés à la catégorie
         *
        if( !empty( $repo->getHowMuchProductsByCategory($ID) ) ){
            $this->addFlash('notice-danger', 'La catégorie contient des produits, elle ne peut pas être supprimé !');
            return $this->redirectToRoute('admin.category.index');
        }
        */
        $em->remove($userToDelete);
        $em->flush();

        $this->addFlash('notice', 'L\'utilisateur a été supprimé !');

        return $this->redirectToRoute('admin.user.index');
    }
    /**
     * @param ManagerRegistry $doctrine
     * @param Request $request
     * @return string
     *
     * @Route("/user/activate", defaults = { "page" = 1 }, name="admin.user.activate", options = { "expose" = true })
     */
    public function activateUser(ManagerRegistry $doctrine, Request $request)
    {
        return new JsonResponse('ok');
    }
}
