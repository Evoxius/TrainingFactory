<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MemberRepository")
 */
class Member extends Person
{


    /**
     * @ORM\Column(type="string", length=50)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $place;


    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

     /**
    * @ORM\OneToMany(targetEntity="App\Entity\Registration", mappedBy="member")
    */
    private $registration;

      

    public function __construct()
    {
        $this->registration = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }

    public function addRegistration(Registration $a)
    {
        if ($this->registration->contains($a)) {

            return;
        }

        $this->registration->add($a);

    }

    public function setRegistration(Registration $registration)
    {
        $this->registration = $registration;

        return $this;
    }

    public function removeRegistration(Registration $a)
    {
        if (!$this->registration->contains($a)) {
            return;
        }
        $this->registration->removeElement($a);
    }

     /**
    * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="member")
    */
    private $lesson;

    
}
