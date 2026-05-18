<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\ValueType;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestDefinitionsActiveEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

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
    private string $id;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $official_name = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $short_name = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $loinc_code = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $methodology = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'category_mnemonic', referencedColumnName: 'mnemonic', nullable: false)]
    private ?TestCategoriesEntity $category_mnemonic = null;

    #[ORM\Column(type: 'uuid', nullable: false)]
    private Uuid $unit_id;

    #[ORM\Column(Types::INTEGER)]
    private int $version;

    #[ORM\Column(type: 'uuid', nullable: false)]
    private Uuid $specimen_definition_id;

    #[ORM\Column(enumType: ValueType::class)]
    private ?ValueType $value_type = null;

    #[ORM\Column(type: Types::JSONB, nullable: true, options: ['jsonb' => true])]
    private ?array $result_options = null;
    #[ORM\OneToMany(targetEntity: ReferenceRulesActiveEntity::class, mappedBy: 'test_definition_active_id')]
    private Collection $referenceRulesActiveEntity;

    public function __construct($id)
    {
        $this->id = $id;
        $this->referenceRulesActiveEntity = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getOfficialName(): ?string
    {
        return $this->official_name;
    }

    public function setOfficialName(string $official_name): static
    {
        $this->official_name = $official_name;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->short_name;
    }

    public function setShortName(string $short_name): static
    {
        $this->short_name = $short_name;

        return $this;
    }

    public function getLoincCode(): ?string
    {
        return $this->loinc_code;
    }

    public function setLoincCode(string $loinc_code): static
    {
        $this->loinc_code = $loinc_code;

        return $this;
    }

    public function getMethodology(): ?string
    {
        return $this->methodology;
    }

    public function setMethodology(string $methodology): static
    {
        $this->methodology = $methodology;

        return $this;
    }

    public function getCategoryMnemonic(): ?TestCategoriesEntity
    {
        return $this->category_mnemonic;
    }

    public function setCategoryMnemonic(?TestCategoriesEntity $category_mnemonic): static
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

    public function getVersion(): ?int
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

    public function getReferenceRulesActiveEntity(): Collection
    {
        return $this->referenceRulesActiveEntity;
    }

    public function addReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        if (!$this->referenceRulesActiveEntity->contains($rule)) {
            $this->referenceRulesActiveEntity->add($rule);
            $rule->setTestDefinitionId($this);
        }

        return $this;
    }

    public function removeReferenceRule(ReferenceRulesActiveEntity $rule): static
    {
        if ($this->referenceRulesActiveEntity->removeElement($rule)) {
            if ($rule->getTestDefinitionId() === $this) {
                $rule->setTestDefinitionId(null);
            }
        }

        return $this;
    }
}
