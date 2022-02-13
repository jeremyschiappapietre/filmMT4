<?php

namespace App\Controller;

use App\Entity\FilmCategory;
use App\Form\FilmCategoryType;
use App\Repository\FilmCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



/**
 * @Route("/category")
 */
class FilmCategoryController extends AbstractController
{
    /**
     * @Route("/", name="film_category_index", methods={"GET"})
     */
    public function index(FilmCategoryRepository $filmCategoryRepository): Response
    {
        return $this->render('film_category/index.html.twig', [
            'film_categories' => $filmCategoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ASC", name="film_category_asc", methods={"GET"})
     */
    public function sortCategoryASC(FilmCategoryRepository $filmCategoryRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmCategoryRepository->sortASCFilmCategory();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film_category/index.html.twig', [
            'category' => $film,
        ]);
    }
}
