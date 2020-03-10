<?php

namespace AppBundle\Entity;

use AppBundle\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mark
 *
 * @ORM\Table(name="mark")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MarkRepository")
 */
class Mark
{
    /*     
     * @ORM\ManyToOne(targetEntity="Student", inversedBy="mark")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="registerDate", type="datetime")
     */
    private $registerDate;

    /**
     * @var int
     *
     * @ORM\Column(name="student_id", type="integer")
     */
    private $studentId;

    /**
     * @var int
     *
     * @ORM\Column(name="subject_id", type="integer")
     */
    private $subjectId;

    /**
     * @var int
     *
     * @ORM\Column(name="finalMark", type="integer")
     */
    private $finalMark;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set registerDate
     *
     * @param \DateTime $registerDate
     *
     * @return Mark
     */
    public function setRegisterDate($registerDate)
    {
        $this->registerDate = $registerDate;

        return $this;
    }

    /**
     * Get registerDate
     *
     * @return \DateTime
     */
    public function getRegisterDate()
    {
        return $this->registerDate;
    }

    /**
     * Set studentId
     *
     * @param integer $studentId
     *
     * @return Mark
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get studentId
     *
     * @return int
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set subjectId
     *
     * @param integer $subjectId
     *
     * @return Mark
     */
    public function setSubjectId($subjectId)
    {
        $this->subjectId = $subjectId;

        return $this;
    }

    /**
     * Get subjectId
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subjectId;
    }

    /**
     * Set finalMark
     *
     * @param integer $finalMark
     *
     * @return Mark
     */
    public function setFinalMark($finalMark)
    {
        $this->finalMark = $finalMark;

        return $this;
    }

    /**
     * Get finalMark
     *
     * @return int
     */
    public function getFinalMark()
    {
        return $this->finalMark;
    }
}
