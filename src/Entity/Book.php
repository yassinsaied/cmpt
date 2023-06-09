<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["getBooks"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["getBooks"])]
    #[Assert\NotBlank(message: "Le titre du livre est obligatoire")]
    #[Assert\Length(min: 1, max: 255, minMessage: "Le titre doit faire au moins {{ limit }} caractères", maxMessage: "Le titre ne peut pas faire plus de {{ limit }} caractères")]
    private ?string $title = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(["getBooks"])]
    #[Assert\Length(min: 1, max: 255, minMessage: "La description est faire au moins {{ limit }} caractères", maxMessage: "La description ne peut pas faire plus de {{ limit }} caractères")]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["getBooks"])]
    #[Assert\DateTime(format: 'Y-m-d', message: 'la format de la date sous form "Y-m-d"')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    #[Groups(["getBooks"])]
    #[Assert\NotBlank(message: "L'autheur est obligatoire")]
    private ?Author $author = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }
}
