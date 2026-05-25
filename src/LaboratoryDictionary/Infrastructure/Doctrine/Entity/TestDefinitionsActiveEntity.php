<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\ValueType;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestDefinitionsActiveEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestDefinitionsActiveEntityRepository::class)]
#[ORM\Table(
    name: 'test_definitions_active',
    schema: 'laboratory_dictionary',
    options: [
        'check' => 'version >= 0',
    ]
)]
class TestDefinitionsActiveEntity
{
    #[ORM\Id]
    #[ORM\Column(Types::TEXT)]
    public readonly string $id;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $officialName;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $shortName;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $loincCode;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $methodology;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'category_mnemonic', referencedColumnName: 'mnemonic', nullable: false)]
    private TestCategoriesEntity $categoryMnemonic;

    #[ORM\ManyToOne(targetEntity: UnitEntity::class)]
    #[ORM\JoinColumn(name: 'unit_id', referencedColumnName: 'id', nullable: false)]
    private UnitEntity $unit;

    #[ORM\Column(Types::INTEGER)]
    private int $version;

    #[ORM\ManyToOne(targetEntity: SpecimenDefinitionEntity::class)]
    #[ORM\JoinColumn(name: 'specimen_definition_id', referencedColumnName: 'id', nullable: false)]
    private SpecimenDefinitionEntity $specimenDefinition;

    #[ORM\Column(enumType: ValueType::class, nullable: false)]
    private ValueType $valueType;

    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $resultOptions = null;
    #[ORM\OneToMany(targetEntity: ReferenceRulesActiveEntity::class, mappedBy: 'test_definition_active_id')]
    private Collection $referenceRulesActive;

    public function __construct(string $id, string $officialName, string $shortName, string $loincCode, string $methodology,
        TestCategoriesEntity $categoryMnemonic, UnitEntity $unit, int $version, SpecimenDefinitionEntity $specimenDefinition, ValueType $valueType)
    {
        $this->id = $id;
        $this->officialName = $officialName;
        $this->shortName = $shortName;
        $this->loincCode = $loincCode;
        $this->methodology = $methodology;
        $this->categoryMnemonic = $categoryMnemonic;
        $this->unit = $unit;
        $this->version = $version;
        $this->specimenDefinition = $specimenDefinition;
        $this->valueType = $valueType;
        $this->referenceRulesActive = new ArrayCollection();
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

    public function setCategoryMnemonic(TestCategoriesEntity $categoryMnemonic): static
    {
        $this->categoryMnemonic = $categoryMnemonic;

        return $this;
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

    public function getReferenceRulesActive(): array
    {
        return $this->referenceRulesActive->toArray();
    }

    public function addReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        if (!$this->referenceRulesActive->contains($rule)) {
            $this->referenceRulesActive->add($rule);
            $rule->setTestDefinition($this);
        }

        return $this;
    }

    public function removeReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        $this->referenceRulesActive->removeElement($rule);

        return $this;
    }
}
