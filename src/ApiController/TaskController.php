<?php

namespace App\ApiController;

use App\Repository\TaskRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/task", host="api.exotest.fr")
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Task resource
     * @Route("/", name="tasklist_api", methods={ "GET" })
     * @Rest\View()
     */
    public function index(TaskRepository $taskRepository): View
    {
        $task = $taskRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        return View::create($task, Response::HTTP_OK);

    }

}