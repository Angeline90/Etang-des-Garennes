<?php

namespace App\Entity;

use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Post;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\BookingRepository;
use ApiPlatform\Metadata\GetCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use App\Controller\CreateBookingDurationAction;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Controller\ChargePaymentForBookingAction;

#[ORM\Entity(repositoryClass: BookingRepository::class)]
#[ApiResource(
    mercure: true,
    operations: [
        new Get(),
        new GetCollection(),
        new Delete(),
        new Post(controller: CreateBookingDurationAction::class),
        new Patch(
            uriTemplate: 'booking/{id}/payment/charge',
            controller: ChargePaymentForBookingAction::class,
        )
    ]
)]
#[ORM\HasLifecycleCallbacks(),]
#[ApiFilter(DateFilter::class, properties: ['createdAt', 'arrivalDate', 'departureDate'])]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'bookingState' => 'exact'])]
#[ApiResource(
    uriTemplate: '/cottages/{id}/bookings',
    uriVariables: [
        'id' => new Link(
            fromClass: Cottage::class,
            fromProperty: 'bookings'
        )
    ],
    operations: [new GetCollection()]
)]

class Booking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'bookings')]
    private Collection $clients;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $arrivalDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $departureDate = null;

    #[ORM\Column(nullable: true)]
    private ?\DateInterval $duration = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    private ?BookingState $bookingState = null;

    #[ORM\ManyToOne(inversedBy: 'bookings')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Cottage $cottage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $stripe_payment = null;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onCreate(): void
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(User $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients->add($client);
        }

        return $this;
    }

    public function removeClient(User $client): self
    {
        $this->clients->removeElement($client);

        return $this;
    }

    public function getArrivalDate(): ?\DateTimeInterface
    {
        return $this->arrivalDate;
    }

    public function setArrivalDate(?\DateTimeInterface $arrivalDate): self
    {
        $this->arrivalDate = $arrivalDate;

        return $this;
    }

    public function getDepartureDate(): ?\DateTimeInterface
    {
        return $this->departureDate;
    }

    public function setDepartureDate(?\DateTimeInterface $departureDate): self
    {
        $this->departureDate = $departureDate;

        return $this;
    }

    public function getDuration(): ?\DateInterval
    {
        return $this->duration;
    }

    public function setDuration(?\DateInterval $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getBookingState(): ?BookingState
    {
        return $this->bookingState;
    }

    public function setBookingState(?BookingState $bookingState): self
    {
        $this->bookingState = $bookingState;

        return $this;
    }

    public function getCottage(): ?Cottage
    {
        return $this->cottage;
    }

    public function setCottage(?Cottage $cottage): self
    {
        $this->cottage = $cottage;

        return $this;
    }

    public function getFormattedDuration(): int
    {
        return $this->duration->d;
    }

    public function getStripePayment(): ?string
    {
        return $this->stripe_payment;
    }

    public function setStripePayment(?string $stripe_payment): self
    {
        $this->stripe_payment = $stripe_payment;

        return $this;
    }
}
