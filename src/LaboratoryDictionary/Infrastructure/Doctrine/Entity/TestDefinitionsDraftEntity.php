<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\ValueType;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestDefinitionsDraftEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: TestDefinitionsDraftEntityRepository::class)]
#[ORM\Table(name: 'test_definitions_draft', schema: 'laboratory_dictionary', options: ['check' => 'version >= 0'])]
#[ORM\HasLifecycleCallbacks]
class TestDefinitionsDraftEntity
{
    #[ORM\Id]
    #[ORM\Column(type: Types::TEXT)]
    private string $id;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $official_name;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $short_name;

    #[ORM\Column(type: Types::TEXT, unique: true, nullable: false)]
    private string $loinc_code;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $methodology;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    private string $category_mnemonic;

    #[ORM\Column(type: 'uuid', nullable: false)]
    private Uuid $unit_id;

    #[ORM\Column(type: Types::INTEGER, nullable: false)]
    private int $version;

    #[ORM\Column(type: 'uuid', nullable: false)]
    private Uuid $specimen_definition_id;

    #[ORM\Column(
        type: 'string',
        enumType: ValueType::class,
        columnDefinition: 'laboratory_dictionary.value_type NOT NULL'
    )]
    private ValueType $value_type;
    #[ORM\Column(type: Types::JSON, nullable: true, options: ['jsonb' => true])]
    private ?array $result_options = null;

    #[ORM\OneToMany(targetEntity: ReferenceRulesDraftEntity::class, mappedBy: 'test_definition_draft_id', orphanRemoval: true)]
    private Collection $referenceRulesDraftEntity;

    public function __construct(string $id)
    {
        $this->id = $id;
        $this->referenceRulesDraftEntity = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOfficialName(): string
    {
        return $this->official_name;
    }

    public function setOfficialName(string $official_name): static
    {
        $this->official_name = $official_name;

        return $this;
    }

    public function getShortName(): string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getLoincCode(): string
    {
        return $this->loinc_code;
    }

    public function setLoincCode(string $loinc_code): static
    {
        $this->loinc_code = $loinc_code;

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

    public function getCategoryMnemonic(): string
    {
        return $this->category_mnemonic;
    }

    public function setCategoryMnemonic(string $category_mnemonic): static
    {
        $this->category_mnemonic = $category_mnemonic;

        return $this;
    }

    public function getUnitId(): Uuid
    {
        return $this->unit_id;
    }

    public function setUnitId(Uuid $unit_id): static
    {
        $this->unit_id = $unit_id;

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

    public function getSpecimenDefinitionId(): Uuid
    {
        return $this->specimen_definition_id;
    }

    public function setSpecimenDefinitionId(Uuid $specimen_definition_id): static
    {
        $this->specimen_definition_id = $specimen_definition_id;

        return $this;
    }

    public function getValueType(): ValueType
    {
        return $this->value_type;
    }

    public function setValueType(ValueType $value_type): static
    {
        $this->value_type = $value_type;

        return $this;
    }

    public function getResultOptions(): ?array
    {
        return $this->result_options;
    }

    public function setResultOptions(?array $result_options): static
    {
        $this->result_options = $result_options;

        return $this;
    }

    public function getReferenceRulesDraftEntity(): Collection
    {
        return $this->referenceRulesDraftEntity;
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
        if ($this->referenceRulesDraftEntity->removeElement($rule)) {
            if ($rule->getTestDefinitionId() === $this) {
                $rule->setTestDefinition(null);
            }
        }

        return $this;
    }
}
