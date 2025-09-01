<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\BookRepository;
use App\Form\BookType;
use App\Entity\Book;

final class BookController extends AbstractController
{
    #[Route('/book/edit/{id}', name:'book.edit')]
    public function edit(Book $book, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('book/edit.html.twig', [
            'form' => $form
        ]);
    }
}
