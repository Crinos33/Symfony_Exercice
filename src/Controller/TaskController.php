<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * @Route("/task", host="exotest.fr")
 */
class TaskController extends AbstractController
{
    /**
     * @Route("/", name="task_index", methods={"GET"})
     */
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="task_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */

            $entityManager = $this->getDoctrine()->getManager();
            $image =$task->getImage();
            $file = $form->get('image')->get('file')->getData();

            if ($file) {

                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $this->getParameter('image_abs_path'),$fileName

                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $image->setPath($this->getParameter('image_abs_path') . '/' . $fileName);
                $image->setImgPath($this->getParameter('image_path') . '/' . $fileName);
                $entityManager->persist($image);
            }
            else {
                $task->setImage(null);
            }
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('task_index');

        }
        return $this->render('task/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_show", methods={"GET"})
     */
    public function show(Task $task): Response
    {
        return $this->render('task/show.html.twig', [
            'task' => $task,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="task_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Task $task): Response
    {
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $image =$task->getImage();
            $file =$form->get('image')->get('file')->getData();

            if($file) {
                $fileName = $this->generateUniquefileName().'.'.$file->guessExtension();

                try {
                    $file->move(
                        $this->getParameter('image_abs_path'),
                        $fileName
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                $this->removeFile($image->getPath());
                $image->setPath($this->getParameter('image_abs_path').'/'.$fileName);
                $image->setImgPath($this->getParameter('image_path').'/'.$fileName);
                $entityManager->persist($image);
            }

            if(empty($image->getId()) && !$file ){
                $task->setImage(null);
            }



            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('task_index', [
                'id' => $task->getId(),
            ]);
        }

        return $this->render('task/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="task_img_delete", methods={"POST"})
     */
    public function deleteImg(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $image = $task->getImage();
            if($image){
                $this->removeFile($image->getPath());
            }

            $task->setImage(null);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($image);
            $task->setImage(null);
            $entityManager->persist($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_edit', array('id'=>$task->getId()));
    }

    /**
     * @Route("/{id}", name="task_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Task $task): Response
    {
        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $image = $task->getImage();
            if($image){
                $this->removeFile($image->getPath());
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('task_index');
    }

    /**
     * @return string
     */
    function generateUniqueFileName() {

        return md5(uniqid());
    }

    private function removeFile($path){
        if(file_exists($path)){
            unlink($path);
        }
    }
}

