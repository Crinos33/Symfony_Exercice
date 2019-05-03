<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR

        ]);
    }

    /**
     * @Route("/admin", name="homeAdmin")
     */
    //@IsGranted("ROLE_ADMIN")                                                      Autre facon de proteger.
    public function indexAdmin()
    {
        //$this->denyAccessUnlessGranted("ROLE_ADMIN");                             Autre facon de proteger trop noob
        return $this->render('default/index.html.twig',[
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR

    ]);
    }


}

