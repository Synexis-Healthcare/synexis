<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\ContainerEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ContainerEntityRepository::class)]
#[ORM\Table(name: 'containers', schema: 'laboratory_dictionary')]
#[ORM\UniqueConstraint(
    name: 'uq_container_color_volume',
    columns: ['color_title', 'color_hex', 'volume']
)]
class ContainerEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;
    #[ORM\OneToMany(targetEntity: SpecimenDefinitionEntity::class, mappedBy: 'container')]
    private Collection $specimenDefinitions;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $colorTitle = null;

    public function getSpecimenDefinitions(): Collection
    {
        return $this->specimenDefinitions;
    }

    #[ORM\Column(type: Types::STRING, length: 7)]
    private ?string $colorHex = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 4)]
    private ?string $volume = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
        $this->specimenDefinitions = new ArrayCollection();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getColorTitle(): ?string
    {
        return $this->colorTitle;
    }

    public function setColorTitle(string $colorTitle): static
    {
        $this->colorTitle = $colorTitle;

        return $this;
    }

    public function getColorHex(): ?string
    {
        return $this->colorHex;
    }

    public function setColorHex(string $colorHex): static
    {
        $this->colorHex = $colorHex;

        return $this;
    }

    public function getVolume(): ?string
    {
        return $this->volume;
    }

    public function setVolume(string $volume): static
    {
        $this->volume = $volume;

        return $this;
    }
}
