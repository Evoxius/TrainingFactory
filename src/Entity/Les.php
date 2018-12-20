<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LesRepository")
 */
class Les
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $dag;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $tijd;

    /**
     * @ORM\Column(type="string", length=180)
     */
    private $descriptie;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDag(): ?string
    {
        return $this->dag;
    }

    public function setDag(string $dag): self
    {
        $this->dag = $dag;

        return $this;
    }

    public function getTijd(): ?string
    {
        return $this->tijd;
    }

    public function setTijd(string $tijd): self
    {
        $this->tijd = $tijd;

        return $this;
    }

    public function getDescriptie(): ?string
    {
        return $this->descriptie;
    }

    public function setDescriptie(string $descriptie): self
    {
        $this->descriptie = $descriptie;

        return $this;
    }
}
