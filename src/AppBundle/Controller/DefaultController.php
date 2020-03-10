<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\{Controller};
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/Charts", name="charts")
     */
    public function indexCharts(Request $request)
    {
        return $this->render(
            'default/charts.html.twig'
        );
    }

    /**
     * @Route("/studentChart", name="studentChart")
     */
    public function studentChart(Request $request)
    {
        return $this->render(
            'default/studentCharts.html.twig'
        );
    }

    /**
     * @Route("/markChart", name="markChart")
     */
    public function markChart(Request $request)
    {
        return $this->render(
            'default/markCharts.html.twig'
        );
    }

    /**
     * @Route("/markChartAction", name="markChartAction")
     */
    public function markChartAction(Request $request)
    {
        $firstDate = $request->request->get('firstDate');
        $lastDate = $request->request->get('lastDate');
        $em = $this->getDoctrine()->getManager();
        $query =  "SELECT su.id,su.name,AVG(m.finalMark) as totalMarks
                FROM mark m
                INNER JOIN subjects su ON (m.subject_id = su.id)
                WHERE m.registerDate BETWEEN '$firstDate 00:00:00' AND '$lastDate 23:59:59'
                GROUP BY 1,2";
        $result = $em->getConnection()->prepare($query);
        $result->execute();
        $marksAvg = $result->fetchAll();
        return new JsonResponse($marksAvg);
    }

    /**
     * @Route("/studentChartAction", name="studentChartAction")
     */
    public function studentChartAction(Request $request)
    {
        $firstDate = $request->request->get('firstDate');
        $lastDate = $request->request->get('lastDate');
        $em = $this->getDoctrine()->getManager();
        $query =  "SELECT st.id,st.name,AVG(m.finalMark) as totalMarks
                FROM mark m
                INNER JOIN student st ON (m.student_id = st.id)
                WHERE m.registerDate BETWEEN '$firstDate 00:00:00' AND '$lastDate 23:59:59'
                GROUP BY 1,2";
        $result = $em->getConnection()->prepare($query);
        $result->execute();
        $studentAvg = $result->fetchAll();
        return new JsonResponse($studentAvg);
    }
}
