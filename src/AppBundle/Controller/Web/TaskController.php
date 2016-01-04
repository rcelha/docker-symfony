<?php

namespace AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TaskController extends Controller
{
    public function addTaskAction()
    {
        return $this->render(':Tasks:add.html.twig');
    }

    public function getTasksAction()
    {
        $tasks = $this->get('repository.task')->findAll();

        return $this->render(':Tasks:list.html.twig', array('tasks' => $tasks));
    }
}
