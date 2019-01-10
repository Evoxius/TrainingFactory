<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="training")
 * @ORM\Entity(repositoryClass="App\Repository\TrainingRepository")
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
     * @ORM\Column(type="string", length=50)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $duration;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $extra_costs;

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
     * One Training have Many Lessen.
     * @ORM\OneToMany(targetEntity="training", mappedBy="les")
     */

    private $trainings;

    public function __construct()
    {
        $this->trainings = new ArrayCollection();
    }

    public function getTrainings()
    {
        return $this->trainings;
    }

}
