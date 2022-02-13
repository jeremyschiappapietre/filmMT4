<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=FilmCategory::class, mappedBy="category_id")
     */
    private $filmCategories;

    public function __construct()
    {
        $this->filmCategories = new ArrayCollection();
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
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

    /**
     * @return Collection|FilmCategory[]
     */
    public function getFilmCategories(): Collection
    {
        return $this->filmCategories;
    }

    public function addFilmCategory(FilmCategory $filmCategory): self
    {
        if (!$this->filmCategories->contains($filmCategory)) {
            $this->filmCategories[] = $filmCategory;
            $filmCategory->setCategoryId($this);
        }

        return $this;
    }

    public function removeFilmCategory(FilmCategory $filmCategory): self
    {
        if ($this->filmCategories->removeElement($filmCategory)) {
            // set the owning side to null (unless already changed)
            if ($filmCategory->getCategoryId() === $this) {
                $filmCategory->setCategoryId(null);
            }
        }

        return $this;
    }
}
