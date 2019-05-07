<?php

namespace App\ApiController;

use App\Repository\PriorityRepository;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/priority", host="api.exotest.fr")
 */
class PriorityController extends AbstractFOSRestController
{
    /**
     * Retrieves a collection of Task resource
     * @Route("/", name="priority_api", methods={ "POST" })
     * @Rest\View()
     */
    public function index(PriorityRepository $priorityRepository): View
    {
        $priority = $priorityRepository->findAll();
        // In case our GET was a success we need to return a 200 HTTP OK
        // response with the collection of task object
        return View::create($priority, Response::HTTP_OK);

    }

}