<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
#[ApiResource]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank(message: "Merci de renseigner votre nom et prénom")]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'La saisie {{ value }} est trop courte, elle ne devrait pas faire moins de {{ limit }} caractères',
        maxMessage: 'La saisie {{ value }} est trop longue, elle ne devrait pas dépasser {{ limit }} caractères',
    )]
    private ?string $fullName = null;

    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: 'Merci de renseigner votre e-mail')]
    #[Assert\Email()]
    #[Assert\Length(
        min: 2,
        max: 180,
    )]
    private ?string $email = null;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner le sujet de votre message')]
    #[Assert\Length(
        min: 2,
        max: 100,
        minMessage: 'Le sujet {{ value }} est trop court, il ne devrait pas faire moins de {{ limit }} caractères',
        maxMessage: 'Le sujet {{ value }} est trop long, il ne devrait pas dépasser {{ limit }} caractères',
        )]
    private ?string $subject = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Merci d\'écrire votre message')]
    private ?string $message = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(?string $fullName): self
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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
}
