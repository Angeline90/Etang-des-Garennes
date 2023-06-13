<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\CreateImageAction;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['image_file:read']],
    types: ['https://schema.org/Image'],
    operations: [
        new Get(),
        new GetCollection(),
        new Post(
            controller: CreateImageAction::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'image_file_create']],
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )
        )
    ]
)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $path = null;


    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    private ?Cottage $cottage = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "image_file", fileNameProperty: "path")]
    #[Assert\NotNull(groups: ['image_file_create'])]
    public ?File $file = null;

    #[ORM\OneToOne(mappedBy: 'banner', cascade: ['persist', 'remove'])]
    private ?Cottage $cottageBanner = null;

    #[ORM\OneToOne(mappedBy: 'card', cascade: ['persist', 'remove'])]
    private ?Cottage $cottageCard = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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

    public function getContentUrl(): ?string
    {
        return $this->contentUrl;
    }

    public function setContentUrl(?string $contentUrl): self
    {
        $this->contentUrl = $contentUrl;

        return $this;
    }

    public function getCottageBanner(): ?Cottage
    {
        return $this->cottageBanner;
    }

    public function setCottageBanner(?Cottage $cottageBanner): self
    {
        // unset the owning side of the relation if necessary
        if ($cottageBanner === null && $this->cottageBanner !== null) {
            $this->cottageBanner->setBanner(null);
        }

        // set the owning side of the relation if necessary
        if ($cottageBanner !== null && $cottageBanner->getBanner() !== $this) {
            $cottageBanner->setBanner($this);
        }

        $this->cottageBanner = $cottageBanner;

        return $this;
    }

    public function getCottageCard(): ?Cottage
    {
        return $this->cottageCard;
    }

    public function setCottageCard(?Cottage $cottageCard): self
    {
        // unset the owning side of the relation if necessary
        if ($cottageCard === null && $this->cottageCard !== null) {
            $this->cottageCard->setCard(null);
        }

        // set the owning side of the relation if necessary
        if ($cottageCard !== null && $cottageCard->getCard() !== $this) {
            $cottageCard->setCard($this);
        }

        $this->cottageCard = $cottageCard;

        return $this;
    }
}
