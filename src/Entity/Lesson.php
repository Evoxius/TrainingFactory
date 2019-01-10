<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\Column(type="string", length=50)
     */
    private $time;

    /**
     * @ORM\Column(type="datetime")
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

    public function getTime(): ?string
    {
        return $this->time;
    }

    public function setTime(string $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
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
     * @ORM\OneToMany(targetEntity="Instructor", mappedBy="lesson")
     */

    private $instructors;

    public function __construct()
    {
        $this->instructors = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    public function getInstructors()
    {
        return $this->instructors;
    }

     /**
     * One Lesson have Many Registrations.
     * @ORM\OneToMany(targetEntity="Registration", mappedBy="lesson")
     */

    private $registrations;

    public function getRegistrations()
    {
        return $this->registrations;
    }

    /**
     * Many Lessons has Many Activities.
     * @ORM\ManyToMany(targetEntity="Person", inversedBy="lesson")
     */
    private $person;
}
