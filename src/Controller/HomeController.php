<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Form\BookType;
use App\Entity\Book;

final class HomeController extends AbstractController
{

    private const BOOKS_PER_PAGE = 10;

    #[Route('/', name: 'app_home')]
    public function index(Request $request, BookRepository $bookRepository): Response
    {
        $page = (int) $request->query->get('page', 1);
        $books = $bookRepository->getPaginatedBooks($page, self::BOOKS_PER_PAGE);
        return $this->render('home/index.html.twig', [
            'books' => $books,
            'page' => $page,
            'totalPages' => ceil($books->count() / self::BOOKS_PER_PAGE)
        ]);
    }

}
