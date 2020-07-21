<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Service\UploaderHelper;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PhaseRepository")
 */
class Phase
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="phases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getIdRecipe(): ?Recipe
    {
        return $this->id_recipe;
    }

    public function setIdRecipe(?Recipe $id_recipe): self
    {
        $this->id_recipe = $id_recipe;

        return $this;
    }
	
	public function getImagePath()
    {
        return UploaderHelper::RECIPE_IMAGES.'/'.$this->getPhoto();
    }
}
