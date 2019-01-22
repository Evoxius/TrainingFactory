<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * @ORM\Table(name="training")
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
 * @Vich\Uploadable
 */
class Training
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=190)
     */
    private $description;

      /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $extra_costs;

     /**
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="Please, upload the image as a png or jpeg file.")
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     */
    private $image;

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }


  

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDuration(): ?string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getExtraCosts(): ?string
    {
        return $this->extra_costs;
    }

    public function setExtraCosts(string $extra_costs): self
    {
        $this->extra_costs = $extra_costs;

        return $this;
    }


    /**
    * @ORM\OneToMany(targetEntity="App\Entity\Lesson", mappedBy="training")
    */
    private $lesson;

}
