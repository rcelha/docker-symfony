<?php

namespace AppBundle\Controller;

use AppBundle\Document\Task;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class TasksController extends FOSRestController
{
    public function getTasksAction()
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $tasks = $dm->getRepository('AppBundle:Task')->findAll();

        $view = $this->view($tasks, 200);

        return $this->handleView($view);
    }

    public function getTaskAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $task = $dm->getRepository('AppBundle:Task')->find($id);

        if (empty($task)) {
            throw new HttpException(404, 'Task not found.');
        }

        $view = $this->view($task, 200);

        return $this->handleView($view);
    }

    public function postTasksAction(Request $request)
    {
        $name = $request->get('name');

        if (empty($name)) {
            throw new HttpException(400, 'Missing required parameters');
        }

        $task = new Task();
        $task->setName($name);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($task);
        $dm->flush();

        $view = $this->view($task, 201);

        return $this->handleView($view);
    }
}
