<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Table(name="lesson")
 * @ORM\Entity(repositoryClass="App\Repository\LessonRepository")
 */
class Lesson
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="time", length=50)
     */
    private $time;

    /**
     * @var \DateTime
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $max_persons;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Activiteit
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Lesson
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMaxPersons(): ?int
    {
        return $this->max_persons;
    }

    public function setMaxPersons(int $max_persons): self
    {
        $this->max_persons = $max_persons;

        return $this;
    }

    /**
     * One Lesson have Many Instructors.
     * @ORM\ManyToOne(targetEntity="App\Entity\Instructor", inversedBy="lesson")
     */

    private $instructor;


    public function getInstructor()
    {
        return $this->instructor;
    }


     /**
     * One Lesson have Many Trainings.
     * @ORM\ManyToOne(targetEntity="App\Entity\Training", inversedBy="lesson")
     */

    private $training;

    public function __construct()
    {
        $this->training = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
        $this->registration = new ArrayCollection();
    }


    public function getTraining()
    {
        return $this->training;
    }

    public function setTraining(Training $training)
    {
        $this->training = $training;

        return $this;
    }

    public function addTraining(Training $training)
    {
        if ($this->training->contains($training)) {

            return;
        }

        $this->training->add($training);

    }

    public function removeTraining(Training $training)
    {
        if (!$this->training->contains($training)) {
            return;
        }
        $this->training->removeElement($training);
    }

    /**
     * Many Lessons has Many Activities.
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="lesson")
     */
    private $member;

    public function getMember()
    {
        return $this->member;
    }

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Registration", mappedBy="lesson")
    */
    private $registration;

    
}
