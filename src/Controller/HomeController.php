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
    #[Route('/', name: 'app_home')]
    public function index(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->getSortedBooks();
        return $this->render('home/index.html.twig', [
            'books' => $books,
        ]);
    }

}
