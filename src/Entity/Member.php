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

      /**
     * One Lesson has Many Activities.
     * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="member")
     * @ORM\JoinTable(name="Registration")
     */
    private $lesson;

    public function __construct()
    {
        $this->lesson = new \Doctrine\Common\Collections\ArrayCollection();
        $this->isActive = true;
    }

    public function addLesson(Lesson $a)
    {
        if ($this->lesson->contains($a)) {

            return;
        }

        $this->lesson->add($a);

    }

    public function removeLesson(Lesson $a)
    {
        if (!$this->lesson->contains($a)) {
            return;
        }
        $this->lesson->removeElement($a);
    }
}
