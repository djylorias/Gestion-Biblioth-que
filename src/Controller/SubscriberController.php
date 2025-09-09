<?php

namespace App\Controller;

use App\Entity\Subscriber;
use App\Form\SubscriberType;
use App\Repository\SubscriberRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/subscriber')]
final class SubscriberController extends AbstractController
{
    #[Route(name: 'app_subscriber_index', methods: ['GET'])]
    public function index(SubscriberRepository $subscriberRepository): Response
    {
        return $this->render('subscriber/index.html.twig', [
            'subscribers' => $subscriberRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_subscriber_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subscriber = new Subscriber();
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($subscriber);
            $entityManager->flush();

            return $this->redirectToRoute('app_subscriber_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscriber/new.html.twig', [
            'subscriber' => $subscriber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscriber_show', methods: ['GET'])]
    public function show(Subscriber $subscriber): Response
    {
        return $this->render('subscriber/show.html.twig', [
            'subscriber' => $subscriber,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_subscriber_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Subscriber $subscriber, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SubscriberType::class, $subscriber);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_subscriber_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('subscriber/edit.html.twig', [
            'subscriber' => $subscriber,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_subscriber_delete', methods: ['POST'])]
    public function delete(Request $request, Subscriber $subscriber, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$subscriber->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($subscriber);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_subscriber_index', [], Response::HTTP_SEE_OTHER);
    }
}
