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

    #[Route('/book/{id}', name:'book.show')]
    public function show(Book $book): Response
    {
        return $this->render('book/show.html.twig', [
            'book' => $book
        ]);
    }

    #[Route('/book/create', name:'book.create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(BookType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();
            $em->persist($book);
            $em->flush();
            return $this->redirectToRoute('book.show', ['id' => $book->getId()]);
        }

        return $this->render('book/edit.html.twig', [
            'form' => $form
        ]);
    }

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
