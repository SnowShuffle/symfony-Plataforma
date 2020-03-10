<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\{Controller};
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/Students", name="students")
     */
    public function indexStudents(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Student');
        $students = $repository->findAll();
        // replace this example code with whatever you need
        return $this->render(
            'default/Student.html.twig',
            array('students' => $students)
        );
    }

    /**
     * @Route("/Subjects", name="subjects")
     */
    public function indexSubjects(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Subjects');
        $subjects = $repository->findAll();
        // replace this example code with whatever you need
        return $this->render(
            'default/Subject.html.twig',
            array('subjects' => $subjects)
        );
    }

    /**
     * @Route("/Mark", name="mark")
     */
    public function indexMark(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Mark');
        $marks = $repository->findAll();
        // replace this example code with whatever you need
        return $this->render(
            'default/Mark.html.twig',
            array('marks' => $marks)
        );
    }
}
