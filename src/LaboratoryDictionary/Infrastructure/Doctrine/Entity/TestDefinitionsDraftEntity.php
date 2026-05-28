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
#[ORM\Table(name: 'test_definitions_draft', schema: 'laboratory_dictionary', options: ['check' => 'version >= 0'])]

class TestDefinitionsDraftEntity extends TestDefinitionsLiveEntity
{
    /** @var Collection<int, ReferenceRulesDraftEntity> */
    #[ORM\OneToMany(targetEntity: ReferenceRulesDraftEntity::class, mappedBy: 'testDefinition', orphanRemoval: true)]
    private Collection $referenceRulesDraftEntity;

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

        $this->referenceRulesDraftEntity = new ArrayCollection();
    }

    public array $referenceRules {
        get => $this->referenceRulesDraftEntity->toArray();
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
