<?php

namespace App\Entity;

use App\Repository\SubscriberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: SubscriberRepository::class)]
#[UniqueEntity(
    fields: ['email'],
    message: 'Cette adresse email est déjà utilisée par un autre abonné.'
)]
class Subscriber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Book>
     */
    #[ORM\OneToMany(targetEntity: Book::class, mappedBy: 'is_borrowed')]
    private Collection $books;

    #[Assert\Regex(
        pattern: "/^[\p{L}\s\-]+$/u",
        message: "Le prénom ne peut contenir que des lettres, espaces ou tirets."
    )]
    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[Assert\Regex(
        pattern: "/^[\p{L}\s\-]+$/u",
        message: "Le nom ne peut contenir que des lettres, espaces ou tirets."
    )]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Assert\Email(message: "l'email {{ value }} n'est pas un email valide.")]
    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    public function __construct()
    {
        $this->books = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Book>
     */
    public function getBooks(): Collection
    {
        return $this->books;
    }

    public function addBook(Book $book): static
    {
        if (!$this->books->contains($book)) {
            $this->books->add($book);
            $book->setIsBorrowed($this);
        }

        return $this;
    }

    public function removeBook(Book $book): static
    {
        if ($this->books->removeElement($book)) {
            // set the owning side to null (unless already changed)
            if ($book->getIsBorrowed() === $this) {
                $book->setIsBorrowed(null);
            }
        }

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    // Return the full name of the subscriber as "firstname lastname"
    public function getFullname(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getBorrowedBooksCount(): int
    {
        return $this->books->count();
    }

}
