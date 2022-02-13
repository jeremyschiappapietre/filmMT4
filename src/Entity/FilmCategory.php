<?php

namespace App\Entity;

use App\Repository\FilmCategoryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FilmCategoryRepository::class)
 */
class FilmCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $film_id;

    /**
     * @ORM\ManyToOne(targetEntity=category::class, inversedBy="filmCategories")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category_id;

    public function getFilmId(): ?int
    {
        return $this->film_id;
    }

    public function getCategoryId(): ?category
    {
        return $this->category_id;
    }

    public function setCategoryId(?category $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }
}
