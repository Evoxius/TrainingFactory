<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


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
     * @ORM\Column(type="time", length=50)
     */
    private $time;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="date", length=50)
     */
    private $date;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="string", length=50)
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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): self
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

    private $instructors;

    public function __construct()
    {
      
       
    }

    public function getInstructors()
    {
        return $this->instructors;
    }

     /**
     * One Lesson have Many Trainings.
     * @ORM\ManyToOne(targetEntity="App\Entity\Training", inversedBy="lesson")
     */

    private $trainings;

    public function getRegistrations()
    {
        return $this->trainings;
    }

    /**
     * Many Lessons has Many Activities.
     * @ORM\ManyToMany(targetEntity="App\Entity\Person", inversedBy="lesson")
     */
    private $person;
}
