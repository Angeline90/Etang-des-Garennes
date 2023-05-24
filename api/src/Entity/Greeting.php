<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * This is a dummy entity. Remove it!
 */
#[ApiResource(mercure: true)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'name' => 'ipartial'])]
#[ORM\Entity]
class Greeting
{
    /**
     * The entity ID
     */
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private ?int $id = null;

    /**
     * A nice person
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    public string $name = '';

    public function getId(): ?int
    {
        return $this->id;
    }
}
