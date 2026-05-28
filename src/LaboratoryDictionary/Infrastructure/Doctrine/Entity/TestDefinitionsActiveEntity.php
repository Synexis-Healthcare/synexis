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
#[ORM\AttributeOverrides([
    new ORM\AttributeOverride(
        name: 'officialName',
        column: new ORM\Column(type: Types::TEXT, unique: true, nullable: false)
    ),
    new ORM\AttributeOverride(
        name: 'shortName',
        column: new ORM\Column(type: Types::TEXT, unique: true, nullable: false)
    ),
    new ORM\AttributeOverride(
        name: 'loincCode',
        column: new ORM\Column(type: Types::TEXT, unique: true, nullable: false)
    ),
    new ORM\AttributeOverride(
        name: 'methodology',
        column: new ORM\Column(type: Types::TEXT, nullable: false)
    ),
    new ORM\AttributeOverride(
        name: 'valueType',
        column: new ORM\Column(type: 'string', enumType: ValueType::class, nullable: false)
    ),
])]
#[ORM\Table(name: 'test_definitions_active', schema: 'laboratory_dictionary', options: ['check' => 'version >= 0'])]
class TestDefinitionsActiveEntity extends TestDefinitionsLiveEntity
{
    /** @var Collection<int, ReferenceRulesActiveEntity> */
    #[ORM\OneToMany(targetEntity: ReferenceRulesActiveEntity::class, mappedBy: 'testDefinition', orphanRemoval: true)]
    private Collection $referenceRulesCollection;

    public function __construct(
        string $id,
        string $officialName,
        string $shortName,
        string $loincCode,
        string $methodology,
        TestCategoriesEntity $categoryMnemonic,
        UnitEntity $unit,
        int $version,
        SpecimenDefinitionEntity $specimenDefinition,
        ValueType $valueType,
    ) {
        parent::__construct(
            $id,
            $officialName,
            $shortName,
            $loincCode,
            $methodology,
            $categoryMnemonic,
            $unit,
            $version,
            $specimenDefinition,
            $valueType
        );

        $this->referenceRulesCollection = new ArrayCollection();
    }

    public array $referenceRulesActive {
        get => $this->referenceRulesCollection->toArray();
    }

    public function addReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        if (!$this->referenceRulesCollection->contains($rule)) {
            $this->referenceRulesCollection->add($rule);
            $rule->setTestDefinition($this);
        }

        return $this;
    }

    public function removeReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        $this->referenceRulesCollection->removeElement($rule);

        return $this;
    }
}
