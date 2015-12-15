<?php

namespace BebrasBundle\Controller;

use BebrasBundle\Entity\Repository\StudentRepository;
use BebrasBundle\Entity\Student;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\Controller\FOSRestController;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @author Tadas Gliaubicas
 */
class StudentController extends FOSRestController
{

    /**
     * List all students.
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @return array
     */
    public function getStudentsAction()
    {
        $students = $this->getRepository()->findAll();

        return $students;
    }

    /**
     * Get a single student.
     *
     * @ApiDoc(
     *   output = "BebrasBundle\Entity\Student",
     *   statusCodes = {
     *     200 = "Returned when successful",
     *     404 = "Returned when the student is not found"
     *   }
     * )
     *
     * @param int $id
     *
     * @return array
     *
     * @throws NotFoundHttpException
     */
    public function getStudentAction($id)
    {
        $student = $this->getStudentOr404($id);

        return $student;
    }

    /**
     * @return StudentRepository
     */
    private function getRepository()
    {
        return $this->container->get('bebras.repository.student');
    }

    /**
     * @param int $studentId
     *
     * @return Student
     *
     * @throws NotFoundHttpException
     */
    private function getStudentOr404($studentId)
    {
        $student = $this->getRepository()->find($studentId);

        if (null === $student) {
            throw $this->createNotFoundException("Student does not exist.");
        }

        return $student;
    }
}
