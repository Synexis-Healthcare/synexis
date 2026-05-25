<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\ValueType;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestDefinitionsArchiveEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestDefinitionsArchiveEntityRepository::class)]
#[ORM\Table(name: 'test_definitions_archive', schema: 'laboratory_dictionary')]
class TestDefinitionsArchiveEntity
{
    #[ORM\Id]
    #[ORM\Column(Types::TEXT)]
    public readonly string $id;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $officialName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shortName = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $loincCode = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $methodology = null;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $referenceRulesSnapshot = null;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $categorySnapshot = null;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $unitSnapshot = null;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private int $version;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $specimenDefinitionSnapshot = null;

    #[ORM\Column(enumType: ValueType::class)]
    private ?ValueType $valueType = null;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $resultOptions = null;

    public function __construct(string $id, int $version)
    {
        $this->id = $id;
        $this->version = $version;
    }

    public function getOfficialName(): ?string
    {
        return $this->officialName;
    }

    public function setOfficialName(?string $officialName): static
    {
        $this->officialName = $officialName;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->shortName;
    }

    public function setShortName(?string $shortName): static
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getLoincCode(): ?string
    {
        return $this->loincCode;
    }

    public function setLoincCode(?string $loincCode): static
    {
        $this->loincCode = $loincCode;

        return $this;
    }

    public function getMethodology(): ?string
    {
        return $this->methodology;
    }

    public function setMethodology(?string $methodology): static
    {
        $this->methodology = $methodology;

        return $this;
    }

    public function getReferenceRulesSnapshot(): ?array
    {
        return $this->referenceRulesSnapshot;
    }

    public function setReferenceRulesSnapshot(?array $referenceRulesSnapshot): static
    {
        $this->referenceRulesSnapshot = $referenceRulesSnapshot;

        return $this;
    }

    public function getCategorySnapshot(): ?array
    {
        return $this->categorySnapshot;
    }

    public function setCategorySnapshot(?array $categorySnapshot): static
    {
        $this->categorySnapshot = $categorySnapshot;

        return $this;
    }

    public function getUnitSnapshot(): ?array
    {
        return $this->unitSnapshot;
    }

    public function setUnitSnapshot(?array $unitSnapshot): static
    {
        $this->unitSnapshot = $unitSnapshot;

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): static
    {
        $this->version = $version;

        return $this;
    }

    public function getSpecimenDefinitionSnapshot(): ?array
    {
        return $this->specimenDefinitionSnapshot;
    }

    public function setSpecimenDefinitionSnapshot(?array $specimenDefinitionSnapshot): static
    {
        $this->specimenDefinitionSnapshot = $specimenDefinitionSnapshot;

        return $this;
    }

    public function getValueType(): ?ValueType
    {
        return $this->valueType;
    }

    public function setValueType(ValueType $valueType): static
    {
        $this->valueType = $valueType;

        return $this;
    }

    public function getResultOptions(): ?array
    {
        return $this->resultOptions;
    }

    public function setResultOptions(?array $resultOptions): static
    {
        $this->resultOptions = $resultOptions;

        return $this;
    }
}
