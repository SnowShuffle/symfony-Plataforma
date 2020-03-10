<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Student;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, IntegerType};


class StudentController extends Controller
{

    /**
     * @Route("/insert/student",name="insert_student")
     */
    public function insertStudent(Request $request)
    {
        $form = $this->studentForm(new Student());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $studentValues = $form->getData();
            $student = new Student();
            $student->setName($studentValues['name']);
            $student->setAge($studentValues['age']);
            $student->setGrade($studentValues['grade']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($student);
            $em->flush();

            return $this->redirectToRoute('students');
        }

        return $this->render(
            'default/createStudent.html.twig',
            [
                'createStudentForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/get/students",name="get_students")
     */
    public function getAllStudents()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Student');
        $students = $repository->findAll();
        return $students;
    }

    /**
     * @Route("/update/student/{id}",name="update_student")
     */
    public function updateStudent(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('AppBundle:Student')->find($id);
        if (!$student) {
            throw $this->createNotFoundException(
                "El estudiante con el id $id no existe"
            );
        }

        $form = $this->studentForm($student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $studentValues = $form->getData();
            $student->setName($studentValues['name']);
            $student->setAge($studentValues['age']);
            $student->setGrade($studentValues['grade']);
            $em->flush();
            return $this->redirectToRoute('students');
        }
        return $this->render(
            'default/createStudent.html.twig',
            [
                'createStudentForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/student/{id}",name="delete_student")
     */
    public function deleteStudent($id)
    {
        $em = $this->getDoctrine()->getManager();
        $student = $em->getRepository('AppBundle:Student')->find($id);
        if (!$student) {
            throw $this->createNotFoundException(
                "El estudiante con el id $id no existe"
            );
        }
        $em->remove($student);
        $em->flush();
        return $this->redirectToRoute('students');
    }


    public function studentForm(Student $values)
    {
        dump($values);
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Nombre', 'attr' => ['value' => $values->getName()]])
            ->add('age', IntegerType::class, ['label' => 'Edad', 'attr' => ['value' => $values->getAge()]])
            ->add('grade', IntegerType::class, ['label' => 'Grado', 'attr' => ['value' => $values->getGrade()]])
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Crear',
                    'attr'   => ['class' => 'btn btn-success']
                ]
            )
            ->getForm();
        return $form;
    }
}
