<?php

namespace App\Controller;

use App\Entity\Tasklist;
use App\Form\TasklistType;
use App\Repository\TasklistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/tasklist")
 */
class TasklistController extends AbstractController
{
    /**
     * @Route("/", name="tasklist_index", methods={"GET"})
     */
    public function index(TasklistRepository $tasklistRepository): Response
    {
        return $this->render('tasklist/index.html.twig', [
            'tasklists' => $tasklistRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="tasklist_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $tasklist = new Tasklist();
        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tasklist);
            $entityManager->flush();

            return $this->redirectToRoute('tasklist_index');
        }

        return $this->render('tasklist/new.html.twig', [
            'tasklist' => $tasklist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tasklist_show", methods={"GET"})
     */
    public function show(Tasklist $tasklist): Response
    {
        return $this->render('tasklist/show.html.twig', [
            'tasklist' => $tasklist,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="tasklist_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Tasklist $tasklist): Response
    {
        $form = $this->createForm(TasklistType::class, $tasklist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tasklist_index', [
                'id' => $tasklist->getId(),
            ]);
        }

        return $this->render('tasklist/edit.html.twig', [
            'tasklist' => $tasklist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="tasklist_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Tasklist $tasklist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tasklist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tasklist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('tasklist_index');
    }
}
