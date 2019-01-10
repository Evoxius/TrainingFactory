<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InstructorRepository")
 */
class Instructor extends Person
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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

    public function getId(): ?int
    {
        return $this->id;
    }

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
}
