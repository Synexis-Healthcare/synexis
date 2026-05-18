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
    private string $id;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $official_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $loinc_code = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $methodology = null;

    #[ORM\Column(type: Types::JSONB, nullable: true, options: ['jsonb' => true])]
    private $reference_rules_snapshot;

    #[ORM\Column(type: Types::JSONB, nullable: true, options: ['jsonb' => true])]
    private $category_snapshot;

    #[ORM\Column(type: Types::JSONB, nullable: true, options: ['jsonb' => true])]
    private $unit_snapshot;

    #[ORM\Id]
    #[ORM\Column(type: Types::INTEGER)]
    private int $version;

    #[ORM\Column(type: Types::JSONB, nullable: true, options: ['jsonb' => true])]
    private $specimen_definition_snapshot;

    #[ORM\Column(enumType: ValueType::class)]
    private ?ValueType $value_type = null;

    #[ORM\Column(type: 'jsonb', nullable: true, options: ['jsonb' => true])]
    private $result_options;

    public function __construct(string $id, int $version)
    {
        $this->id = $id;
        $this->version = $version;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getOfficialName(): ?string
    {
        return $this->official_name;
    }

    public function setOfficialName(?string $official_name): static
    {
        $this->official_name = $official_name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(?string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getLoincCode(): ?string
    {
        return $this->loinc_code;
    }

    public function setLoincCode(?string $loinc_code): static
    {
        $this->loinc_code = $loinc_code;

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

    public function getReferenceRulesSnapshot()
    {
        return $this->reference_rules_snapshot;
    }

    public function setReferenceRulesSnapshot($reference_rules_snapshot): static
    {
        $this->reference_rules_snapshot = $reference_rules_snapshot;

        return $this;
    }

    public function getCategorySnapshot()
    {
        return $this->category_snapshot;
    }

    public function setCategorySnapshot($category_snapshot): static
    {
        $this->category_snapshot = $category_snapshot;

        return $this;
    }

    public function getUnitSnapshot()
    {
        return $this->unit_snapshot;
    }

    public function setUnitSnapshot($unit_snapshot): static
    {
        $this->unit_snapshot = $unit_snapshot;

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

    public function getSpecimenDefinitionSnapshot()
    {
        return $this->specimen_definition_snapshot;
    }

    public function setSpecimenDefinitionSnapshot($specimen_definition_snapshot): static
    {
        $this->specimen_definition_snapshot = $specimen_definition_snapshot;

        return $this;
    }

    public function getValueType(): ?ValueType
    {
        return $this->value_type;
    }

    public function setValueType(ValueType $value_type): static
    {
        $this->value_type = $value_type;

        return $this;
    }

    public function getResultOptions()
    {
        return $this->result_options;
    }

    public function setResultOptions($result_options): static
    {
        $this->result_options = $result_options;

        return $this;
    }
}
