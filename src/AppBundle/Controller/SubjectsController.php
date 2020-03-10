<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Subjects;
use Symfony\Component\Form\Extension\Core\Type\{SubmitType, TextType};

class SubjectsController extends Controller
{
    /**
     * @Route("/insert/subject",name="insert_subject")
     */
    public function insertSubject(Request $request)
    {
        $form = $this->SubjectForm(new Subjects());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $SubjectValues = $form->getData();
            $Subject = new Subjects();
            $Subject->setName($SubjectValues['name']);
            $em = $this->getDoctrine()->getManager();
            $em->persist($Subject);
            $em->flush();

            return $this->redirectToRoute('subjects');
        }

        return $this->render(
            'default/createSubject.html.twig',
            [
                'createSubjectForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/get/subjects",name="get_subjects")
     */
    public function getAllSubjects()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('AppBundle:Subject');
        $Subjects = $repository->findAll();
        return $Subjects;
    }

    /**
     * @Route("/update/subject/{id}",name="update_subject")
     */
    public function updateSubject(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $Subject = $em->getRepository('AppBundle:Subjects')->find($id);
        if (!$Subject) {
            throw $this->createNotFoundException(
                "El estudiante con el id $id no existe"
            );
        }

        $form = $this->SubjectForm($Subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $SubjectValues = $form->getData();
            $Subject->setName($SubjectValues['name']);
            $em->flush();
            return $this->redirectToRoute('subjects');
        }
        return $this->render(
            'default/createSubject.html.twig',
            [
                'createSubjectForm' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/delete/subject/{id}",name="delete_subject")
     */
    public function deleteSubject($id)
    {
        $em = $this->getDoctrine()->getManager();
        $Subject = $em->getRepository('AppBundle:Subjects')->find($id);
        if (!$Subject) {
            throw $this->createNotFoundException(
                "El estudiante con el id $id no existe"
            );
        }
        $em->remove($Subject);
        $em->flush();
        return $this->redirectToRoute('subjects');
    }


    public function SubjectForm(Subjects $values)
    {
        dump($values);
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Nombre', 'attr' => ['value' => $values->getName()]])
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
