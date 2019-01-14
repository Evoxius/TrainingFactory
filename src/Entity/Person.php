<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
/**
 * @ORM\Table(name="person")
 * @ORM\Entity(repositoryClass="App\Repository\PersonRepository")
 */
class Person implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank(message="vul gebruikersnaam in")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $password;

    /**
     * @ORM\Column(type="array")
     */
    private $roles = array();

    /**
     * @Assert\Length(max=190)
     * @Assert\NotBlank(message="vul wachtwoord in")
     */
    private $plainPassword;


    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="vul eerste naam in")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="vul tussenvoegsels in in")
     */
    private $preprovision;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="vul laatste naam in")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank(message="vul geboortedatum in")
     */
    private $dateofbirth;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $password): self
    {
        $this->plainPassword = $password;

        return $this;
    }


    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPreprovision(): ?string
    {
        return $this->preprovision;
    }

    public function setPreprovision(string $preprovision): self
    {
        $this->preprovision = $preprovision;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getDateofbirth(): ?string
    {
        return $this->dateofbirth;
    }

    public function setDateofbirth(string $dateofbirth): self
    {
        $this->dateofbirth = $dateofbirth;

        return $this;
    }

    public function getRoles()
    {
        $roles = $this->roles;
        //$roles[] = 'ROLE_MEMBER';

        return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        // allows for chaining
        return $this;
    }

    /**
     * One Lesson has Many Activities.
     * @ORM\OneToMany(targetEntity="Lesson", mappedBy="person")
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


    public function getSalt() {
        return null;
    }

    public function eraseCredentials() {}

    /** @see \Serializable::serialize() */
    public function serialize()
        {
        return serialize(array(
        $this->id,
        $this->username,
        $this->password,
        // see section on salt below
        // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
        {
        list (
        $this->id,
        $this->username,
        $this->password,
        // see section on salt below
        // $this->salt
        ) = unserialize($serialized);
    }
}
