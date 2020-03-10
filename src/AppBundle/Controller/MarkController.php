<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\{Mark, Student};
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType, IntegerType};
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MarkController extends Controller
{

    /**
     * @Route("/insert/mark",name="insert_mark")
     */
    public function insertMark(Request $request)
    {
        $form = $this->markForm(new Mark());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $markValues = $form->getData();
            $mark = new Mark();
            $mark->setRegisterDate(new \DateTime(date("Y-m-d H:i:s")));
            $mark->setStudentId($markValues['student_id']->getId());
            $mark->setSubjectId($markValues['subject_id']->getId());
            $mark->setFinalMark($markValues['final_mark']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($mark);
            $em->flush();

            return $this->redirectToRoute('mark');
        }

        return $this->render(
            'default/createmark.html.twig',
            [
                'createMarkForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/get/mark",name="get_mark")
     */
    public function getAllMark()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Mark');
        $Mark = $repository->findAll();
        return $Mark;
    }

    /**
     * @Route("/update/mark/{id}",name="update_mark")
     */
    public function updateMark(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('AppBundle:Mark')->find($id);
        if (!$mark) {
            throw $this->createNotFoundException(
                "La calificacion con el id $id no existe"
            );
        }

        $form = $this->markForm($mark);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $markValues = $form->getData();
            $mark->setRegisterDate($markValues['register_date']);
            $mark->setStudentId($markValues['student_id']);
            $mark->setSubjectId($markValues['subject_id']);
            $mark->setFinalMark($markValues['final_mark']);
            $em->flush();
            return $this->redirectToRoute('mark');
        }
        return $this->render(
            'default/createmark.html.twig',
            [
                'createmarkForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/mark/{id}",name="delete_mark")
     */
    public function deleteMark($id)
    {
        $em = $this->getDoctrine()->getManager();
        $mark = $em->getRepository('AppBundle:Mark')->find($id);
        if (!$mark) {
            throw $this->createNotFoundException(
                "La calificacion con el id $id no existe"
            );
        }
        $em->remove($mark);
        $em->flush();
        return $this->redirectToRoute('mark');
    }


    public function markForm(Mark $values)
    {
        $form = $this->createFormBuilder()
            ->add(
                'student_id',
                EntityType::class,
                [
                    'class' => 'AppBundle:Student',
                    'choice_label' => 'name',
                    'label' => 'Estudiante'
                ]
            )
            ->add(
                'subject_id',
                EntityType::class,
                [
                    'class' => 'AppBundle:Subjects',
                    'choice_label' => 'name',
                    'label' => 'Materia'
                ]
            )
            ->add(
                'final_mark',
                IntegerType::class,
                [
                    'label' => 'Calificacion Final',
                    'attr' => ['min' => 1, 'max' => 10]
                ]
            )
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
