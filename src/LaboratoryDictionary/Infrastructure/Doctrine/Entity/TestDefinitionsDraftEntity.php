<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\ValueType;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestDefinitionsDraftEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestDefinitionsDraftEntityRepository::class)]
#[ORM\Table(name: 'test_definitions_draft', schema: 'laboratory_dictionary', options: ['check' => 'version >= 0'])]

class TestDefinitionsDraftEntity
{
    #[ORM\Id]
    #[ORM\Column(type: Types::TEXT, unique: true)]
    public readonly string $id;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $officialName;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $shortName;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $loincCode;

    #[ORM\Column(type: Types::TEXT)]
    private string $methodology;

    #[ORM\ManyToOne(targetEntity: TestCategoriesEntity::class, inversedBy: 'testDefinitions')]
    #[ORM\JoinColumn(name: 'category_mnemonic', referencedColumnName: 'mnemonic', nullable: false)]
    private TestCategoriesEntity $categoryMnemonic;

    #[ORM\ManyToOne(targetEntity: UnitEntity::class)]
    #[ORM\JoinColumn(name: 'unit_id', referencedColumnName: 'id', nullable: false)]
    private UnitEntity $unit;

    #[ORM\Column(type: Types::INTEGER)]
    private int $version;

    #[ORM\ManyToOne(targetEntity: SpecimenDefinitionEntity::class)]
    #[ORM\JoinColumn(name: 'specimen_definition_id', referencedColumnName: 'id', nullable: false)]
    private SpecimenDefinitionEntity $specimenDefinition;

    #[ORM\Column(
        type: 'string',
        enumType: ValueType::class,
        columnDefinition: 'laboratory_dictionary.value_type NOT NULL'
    )]
    private ValueType $valueType;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $resultOptions = null;

    #[ORM\OneToMany(targetEntity: ReferenceRulesDraftEntity::class, mappedBy: 'testDefinition', orphanRemoval: true)]
    private Collection $referenceRulesDraftEntity;

    public function __construct(string $id, string $officialName, string $shortName, string $loincCode, string $methodology, TestCategoriesEntity $categoryMnemonic, UnitEntity $unit, SpecimenDefinitionEntity $specimenDefinition, int $version, ValueType $valueType)
    {
        $this->id = $id;
        $this->referenceRulesDraftEntity = new ArrayCollection();

        $this->categoryMnemonic = $categoryMnemonic;
        $this->officialName = $officialName;
        $this->shortName = $shortName;
        $this->loincCode = $loincCode;
        $this->methodology = $methodology;
        $this->unit = $unit;
        $this->specimenDefinition = $specimenDefinition;
        $this->version = $version;
        $this->valueType = $valueType;
    }

    public function getOfficialName(): string
    {
        return $this->officialName;
    }

    public function setOfficialName(string $officialName): static
    {
        $this->officialName = $officialName;

        return $this;
    }

    public function getShortName(): string
    {
        return $this->shortName;
    }

    public function setShortName(string $shortName): static
    {
        $this->shortName = $shortName;

        return $this;
    }

    public function getLoincCode(): string
    {
        return $this->loincCode;
    }

    public function setLoincCode(string $loincCode): static
    {
        $this->loincCode = $loincCode;

        return $this;
    }

    public function getMethodology(): string
    {
        return $this->methodology;
    }

    public function setMethodology(string $methodology): static
    {
        $this->methodology = $methodology;

        return $this;
    }

    public function getCategoryMnemonic(): TestCategoriesEntity
    {
        return $this->categoryMnemonic;
    }

    public function getUnit(): UnitEntity
    {
        return $this->unit;
    }

    public function setUnit(UnitEntity $unit): static
    {
        $this->unit = $unit;

        return $this;
    }

    public function getVersion(): int
    {
        return $this->version;
    }

    public function setVersion(int $version): static
    {
        if ($version < 0) {
            throw new \InvalidArgumentException('Version cannot be negative');
        }
        $this->version = $version;

        return $this;
    }

    public function getSpecimenDefinition(): SpecimenDefinitionEntity
    {
        return $this->specimenDefinition;
    }

    public function setSpecimenDefinition(SpecimenDefinitionEntity $specimenDefinition): static
    {
        $this->specimenDefinition = $specimenDefinition;

        return $this;
    }

    public function getValueType(): ValueType
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

    public function getReferenceRules(): array
    {
        return $this->referenceRulesDraftEntity->toArray();
    }

    public function addReferenceRule(ReferenceRulesDraftEntity $rule): static
    {
        if (!$this->referenceRulesDraftEntity->contains($rule)) {
            $this->referenceRulesDraftEntity->add($rule);
            $rule->setTestDefinition($this);
        }

        return $this;
    }

    public function removeReferenceRule(ReferenceRulesDraftEntity $rule): static
    {
        $this->referenceRulesDraftEntity->removeElement($rule);

        return $this;
    }
}
