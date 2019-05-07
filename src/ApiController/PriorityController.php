<?php

namespace App\ApiController;

use App\Entity\Priority;
use App\Form\PriorityType;
use App\Repository\PriorityRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Rest\Route("/priority", host="api.exotest.fr")
 */
class PriorityController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Task resource
     * @Rest\Get("/", name="prioritylist_api")
     * @Rest\View()
     */
    public function index(PriorityRepository $priorityRepository): View
    {
        $priority = $priorityRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        return View::create($priority, Response::HTTP_OK);

    }

    /**
     * @Rest\Get("/{id}", name="priorityshow_api")
     * @Rest\View()
     */
    public function show(Priority $priority): View
    {
        return View::create($priority, Response::HTTP_OK);

    }

    /**
     * @Rest\Post("/new", name="prioritycreate_api")
     * @Rest\View()
     */
    public function create(Request $request): View
    {
        $priority = new Priority();
        $priority->setName($request->get('name'));
        $priority->setValue($request->get('value'));
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($priority);
        $entityManager->flush();
        return View::create($priority, Response::HTTP_CREATED);

    }
    /**
     * @Rest\Put("/{id}", name="priorityedit_api")
     * @Rest\View()
     */
    public function edit(Request $request, Priority $priority): View
    {
        if($priority){
            $priority->setName($request->get('name'));
            $priority->setValue($request->get('value'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($priority);
            $entityManager->flush();
        }
        return View::create($priority, Response::HTTP_OK);
    }

    /**
     * @Rest\Patch("/{id}", name="prioritypatch_api")
     * @Rest\View()
     */
    public function patch(Request $request, Priority $priority):View
    {
        if ($priority){
            $form = $this->createForm(PriorityType::class, $priority);
            $form->submit($request->request->all(), false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($priority);
            $entityManager->flush();
        }
        return View::create($priority, Response::HTTP_OK);

    }



    /**
     * @Rest\Delete("/{id}", name="prioritydelete_api")
     * @param Priority $priority
     * @return View;
     */
    public function delete(Priority $priority): View
    {
        if ($priority){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($priority);
            $entityManager->flush();
        }
        return View::create([], Response::HTTP_NO_CONTENT);

    }

}