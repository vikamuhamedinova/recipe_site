<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CompositionRepository")
 */
class Composition
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $amount;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Dimension", inversedBy="compositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_dimension;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ingredient", inversedBy="compositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_ingredient;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Recipe", inversedBy="compositions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_recipe;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getIdDimension(): ?Dimension
    {
        return $this->id_dimension;
    }

    public function setIdDimension(?Dimension $id_dimension): self
    {
        $this->id_dimension = $id_dimension;

        return $this;
    }

    public function getIdIngredient(): ?Ingredient
    {
        return $this->id_ingredient;
    }

    public function setIdIngredient(?Ingredient $id_ingredient): self
    {
        $this->id_ingredient = $id_ingredient;

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
}
