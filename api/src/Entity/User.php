<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[ApiResource(mercure: true)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Email]
    #[Assert\NotBlank(message: 'Votre email est requis')]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank(message: 'Le mot de passe est requis')]
    #[Assert\Length(
        min:6,
        max: 50,
        minMessage:'Le mot de passe doit être de  {{ limit }} caractères minimum',
        //maxMessage: 'Le mot de passe doit être de  {{ limit }} caractères maximum',
    )]
    private ?string $password = null;

    //double verif du MDP
    //#[Assert\EqualTo(propertyPath='password',message='Vous n'avez pas entré le même mot de passe')]
    //public ?string $confirme_password;
    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\ManyToMany(targetEntity: Booking::class, mappedBy: 'clients')]
    private Collection $bookings;

    #[ORM\ManyToMany(targetEntity: Cottage::class, mappedBy: 'owners', cascade: ['persist'])]
    private Collection $cottages;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Votre nom est requis')]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Lettres uniquement',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Votre prénom est requis')]
    #[Assert\Regex(
        pattern: '/\d/',
        match: false,
        message: 'Lettres uniquement',
    )]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adress = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Regex(
        pattern:'/^[0-9]*$/', 
        message:'Chiffres uniquement',
        )]
    private ?string $phone = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->cottages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->addClient($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            $booking->removeClient($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Cottage>
     */
    public function getCottages(): Collection
    {
        return $this->cottages;
    }

    public function addCottage(Cottage $cottage): self
    {
        if (!$this->cottages->contains($cottage)) {
            $this->cottages->add($cottage);
            $cottage->addOwner($this);
        }

        return $this;
    }

    public function removeCottage(Cottage $cottage): self
    {
        if ($this->cottages->removeElement($cottage)) {
            $cottage->removeOwner($this);
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isOwner(): bool
    {
        return $this->getCottages()->count() > 0;
        

    }
}
