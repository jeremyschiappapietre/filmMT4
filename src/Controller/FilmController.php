<?php

namespace App\Controller;

use App\Entity\Film;
use App\Form\FilmType;
use App\Repository\FilmCategoryRepository;
use App\Repository\FilmRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/film")
 */
class FilmController extends AbstractController
{
    /**
     * @Route("/", name="film_index", methods={"GET"})
     */
    public function index(FilmRepository $filmRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmRepository->findAll();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film/index.html.twig', [
            'films' => $film,
        ]);
    }

    /**
     * @Route("/titleASC", name="film_title_asc", methods={"GET"})
     */
    public function sortTitleASC(FilmRepository $filmRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmRepository->sortASCFilm();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film/index.html.twig', [
            'films' => $film,
        ]);
    }

    /**
     * @Route("/titleDESC", name="film_title_desc", methods={"GET"})
     */
    public function sortTitleDESC(FilmRepository $filmRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmRepository->sortDESCFilm();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film/index.html.twig', [
            'films' => $film,
        ]);
    }

    /**
     * @Route("/rentalASC", name="film_rental_asc", methods={"GET"})
     */
    public function sortRentalASC(FilmRepository $filmRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmRepository->sortASCRental();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film/index.html.twig', [
            'films' => $film,
        ]);
    }

    /**
     * @Route("/rentalDESC", name="film_rental_desc", methods={"GET"})
     */
    public function sortRentalDESC(FilmRepository $filmRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $donnees = $filmRepository->sortDESCRental();
        $film = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),10

        );
        return $this->render('film/index.html.twig', [
            'films' => $film,
        ]);
    }


    /**
     * @Route("/new", name="film_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $film = new Film();
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($film);
            $entityManager->flush();

            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/new.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="film_show", methods={"GET"})
     */
    public function show(Film $film): Response
    {
        return $this->render('film/show.html.twig', [
            'film' => $film,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="film_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Film $film): Response
    {
        $form = $this->createForm(FilmType::class, $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('film_index');
        }

        return $this->render('film/edit.html.twig', [
            'film' => $film,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="film_delete", methods={"POST"})
     */
    public function delete(Request $request, Film $film): Response
    {
        if ($this->isCsrfTokenValid('delete'.$film->getFilmId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($film);
            $entityManager->flush();
        }

        return $this->redirectToRoute('film_index');
    }
}
