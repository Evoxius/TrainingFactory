<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstructorRepository")
 */
class Instructor extends Person
{


    /**
     * @ORM\Column(type="datetime")
     */
    private $hiring_date;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $salary;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $social_sec_number;

    public function getHiringDate(): ?\DateTimeInterface
    {
        return $this->hiring_date;
    }

    public function setHiringDate(\DateTimeInterface $hiring_date): self
    {
        $this->hiring_date = $hiring_date;

        return $this;
    }

    public function getSalary(): ?string
    {
        return $this->salary;
    }

    public function setSalary(string $salary): self
    {
        $this->salary = $salary;

        return $this;
    }

    public function getSocialSecNumber(): ?string
    {
        return $this->social_sec_number;
    }

    public function setSocialSecNumber(string $social_sec_number): self
    {
        $this->social_sec_number = $social_sec_number;

        return $this;
    }

    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="instructor")
    */
    private $lesson;
}
