<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegistrationRepository")
 */
class Registration
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
    private $payment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPayment(): ?string
    {
        return $this->payment;
    }

    public function setPayment(string $payment): self
    {
        $this->payment = $payment;

        return $this;
    }

    /**
     * Many Registration have One Member.
     * @ORM\ManyToOne(targetEntity="App\Entity\Member", inversedBy="registration")
     */

    private $member;

    public function __construct()
    {
        $this->member = new ArrayCollection();
        $this->lesson = new ArrayCollection();
    }

    public function setMember(Member $member)
    {
        $this->member = $member;

        return $this;
    }

    public function getMember()
    {
        return $this->member;
    }


    /**
     * Many Registration have One Lesson.
     * @ORM\ManyToOne(targetEntity="App\Entity\Lesson", inversedBy="registration")
     */

    private $lesson;

    public function getLesson()
    {
        return $this->lesson;
    }

    public function setLesson(Lesson $lesson)
    {
        $this->lesson = $lesson;

        return $this;
    }
}
