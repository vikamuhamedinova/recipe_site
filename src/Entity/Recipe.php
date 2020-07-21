<?php

namespace App\Entity;
use App\Service\UploaderHelper;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $name_recipe;

    /**
     * @ORM\Column(type="integer")

     */
    private $portion;

    /**
     * @ORM\Column(type="integer")
     */
    private $time;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="recipes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_category;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Composition", mappedBy="id_recipe", orphanRemoval=true, cascade={"persist"})
     */
    private $compositions;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Phase", mappedBy="id_recipe", orphanRemoval=true, cascade={"persist"})
     */
    private $phases;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $photo;

    public function __construct()
    {
        $this->compositions = new ArrayCollection();
        $this->phases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameRecipe(): ?string
    {
        return $this->name_recipe;
    }

    public function setNameRecipe(string $name_recipe): self
    {
        $this->name_recipe = $name_recipe;

        return $this;
    }

    public function getPortion(): ?int
    {
        return $this->portion;
    }

    public function setPortion(int $portion): self
    {
        $this->portion = $portion;

        return $this;
    }

    public function getTime(): ?int
    {
        return $this->time;
    }

    public function setTime(int $time): self
    {
        $this->time = $time;

        return $this;
    }

    public function getIdCategory(): ?Category
    {
        return $this->id_category;
    }

    public function setIdCategory(?Category $id_category): self
    {
        $this->id_category = $id_category;

        return $this;
    }

    /**
     * @return Collection|Composition[]
     */
    public function getCompositions(): Collection
    {
        return $this->compositions;
    }

    public function addComposition(Composition $composition): self
    {
        if (!$this->compositions->contains($composition)) {
            $this->compositions[] = $composition;
            $composition->setIdRecipe($this);
        }

        return $this;
    }

    public function removeComposition(Composition $composition): self
    {
        if ($this->compositions->contains($composition)) {
            $this->compositions->removeElement($composition);
            // set the owning side to null (unless already changed)
            if ($composition->getIdRecipe() === $this) {
                $composition->setIdRecipe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Phase[]
     */
    public function getPhases(): Collection
    {
        return $this->phases;
    }

    public function addPhase(Phase $phase): self
    {
        if (!$this->phases->contains($phase)) {
            $this->phases[] = $phase;
            $phase->setIdRecipe($this);
        }

        return $this;
    }

	public function getPhase(int $i): Phase
	{
			return $this->phases[$i];
	}
	
    public function removePhase(Phase $phase): self
    {
        if ($this->phases->contains($phase)) {
            $this->phases->removeElement($phase);
            // set the owning side to null (unless already changed)
            if ($phase->getIdRecipe() === $this) {
                $phase->setIdRecipe(null);
            }
        }
        return $this;
    }
	
	public function __toString()
    {
       	return (string) $this->getNameRecipe();
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
	
	public function getImagePath()
    {
        return UploaderHelper::RECIPE_IMAGES.'/'.$this->getPhoto();
    }
}
