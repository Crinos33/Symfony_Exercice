<?php

namespace App\Controller;

use App\Entity\Listitem;
use App\Form\ListitemType;
use App\Repository\ListitemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/listitem")
 */
class ListitemController extends AbstractController
{
    /**
     * @Route("/", name="listitem_index", methods={"GET"})
     */
    public function index(ListitemRepository $listitemRepository): Response
    {
        return $this->render('listitem/index.html.twig', [
            'listitems' => $listitemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="listitem_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $listitem = new Listitem();
        $form = $this->createForm(ListitemType::class, $listitem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($listitem);
            $entityManager->flush();

            return $this->redirectToRoute('listitem_index');
        }

        return $this->render('listitem/new.html.twig', [
            'listitem' => $listitem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listitem_show", methods={"GET"})
     */
    public function show(Listitem $listitem): Response
    {
        return $this->render('listitem/show.html.twig', [
            'listitem' => $listitem,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="listitem_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Listitem $listitem): Response
    {
        $form = $this->createForm(ListitemType::class, $listitem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listitem_index', [
                'id' => $listitem->getId(),
            ]);
        }

        return $this->render('listitem/edit.html.twig', [
            'listitem' => $listitem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="listitem_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Listitem $listitem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$listitem->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($listitem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('listitem_index');
    }
}
