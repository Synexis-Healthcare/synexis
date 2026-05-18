<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\SpecimenDefinitionEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: SpecimenDefinitionEntityRepository::class)]
#[ORM\Table(name: 'specimen_definitions', schema: 'laboratory_dictionary')]
#[UniqueConstraint(
    name: 'uq_specimen_definition_biomaterial_container_filler',
    columns: ['biomaterial', 'container_id', 'filler']
)]
class SpecimenDefinitionEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $biomaterial = null;

    #[ManyToOne(targetEntity: ContainerEntity::class, inversedBy: 'specimenDefinitions')]
    #[ORM\JoinColumn(name: 'container_id', referencedColumnName: 'id', nullable: false)]
    private ContainerEntity $container;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $filler = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $temperature_condition = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $stability_period = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $preparation_requirements = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getBiomaterial(): ?string
    {
        return $this->biomaterial;
    }

    public function setBiomaterial(string $biomaterial): static
    {
        $this->biomaterial = $biomaterial;

        return $this;
    }

    public function getContainer(): ContainerEntity
    {
        return $this->container;
    }

    public function setContainerId(ContainerEntity $container): static
    {
        $this->container = $container;

        return $this;
    }

    public function getFiller(): ?string
    {
        return $this->filler;
    }

    public function setFiller(string $filler): static
    {
        $this->filler = $filler;

        return $this;
    }

    public function getTemperatureCondition(): ?string
    {
        return $this->temperature_condition;
    }

    public function setTemperatureCondition(string $temperature_condition): static
    {
        $this->temperature_condition = $temperature_condition;

        return $this;
    }

    public function getStabilityPeriod(): ?string
    {
        return $this->stability_period;
    }

    public function setStabilityPeriod(string $stability_period): static
    {
        $this->stability_period = $stability_period;

        return $this;
    }

    public function getPreparationRequirements(): ?string
    {
        return $this->preparation_requirements;
    }

    public function setPreparationRequirements(string $preparation_requirements): static
    {
        $this->preparation_requirements = $preparation_requirements;

        return $this;
    }
}
