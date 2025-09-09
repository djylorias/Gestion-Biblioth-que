<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le titre doit être renseigné.")]
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[Assert\NotBlank(message: "Le synopsis doit être renseigné.")]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $synopsis = null;

    #[Assert\NotBlank(message: "Le nombre de pages doit être renseigné.")]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $nb_pages = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(
        name: 'borrower_id',
        referencedColumnName: 'id',
        nullable: true,
        onDelete: 'SET NULL'
    )]
    private ?Subscriber $is_borrowed = null;

    #[Assert\NotBlank(message: "Le nom de l’auteur doit être renseigné.")]
    #[Assert\Regex(
        pattern: "/^[\p{L}\s\-]+$/u",
        message: "Le nom de l’auteur ne doit contenir que des lettres, espaces ou tirets."
    )]
    #[ORM\Column(length: 255)]
    private ?string $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): static
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getNbPages(): ?int
    {
        return $this->nb_pages;
    }

    public function setNbPages(int $nb_pages): static
    {
        $this->nb_pages = $nb_pages;

        return $this;
    }

    public function getIsBorrowed(): ?Subscriber
    {
        return $this->is_borrowed;
    }

    public function setIsBorrowed(?Subscriber $is_borrowed): static
    {
        $this->is_borrowed = $is_borrowed;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;

        return $this;
    }

    // Return HTML version of the book availability status
    public function availability(): string
    {
        if($this->is_borrowed) {
            return '<span class="text-red-700">Emprunté par ' . $this->is_borrowed->getFirstname() . ' ' . $this->is_borrowed->getLastname() . '</span>';
        }
        return '<span class="text-green-700">Disponible</span>';
    }
}
