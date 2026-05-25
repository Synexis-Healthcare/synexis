<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\Gender;
use App\LaboratoryDictionary\Domain\Enum\MenstrualPhase;
use App\LaboratoryDictionary\Domain\Enum\PregnancyTrimester;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\ReferenceRulesDraftEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MartinGeorgiev\Doctrine\DBAL\Types\ValueObject\Range;

#[ORM\Entity(repositoryClass: ReferenceRulesDraftEntityRepository::class)]
#[ORM\Table(
    name: 'reference_rules_draft',
    schema: 'laboratory_dictionary',
    options: [
        'check' => 'priority >= 0',
        'comment' => 'Contains EXCLUDE USING gist constraint for reference ambiguity',
    ]
)]
class ReferenceRulesDraftEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: Types::INTEGER)]
    public readonly int $id;
    #[ORM\ManyToOne(targetEntity: TestDefinitionsDraftEntity::class, inversedBy: 'referenceRulesDraftEntity')]
    #[ORM\JoinColumn(name: 'test_definition_id', referencedColumnName: 'id', nullable: false)]
    private TestDefinitionsDraftEntity $testDefinition;
    #[ORM\Column(enumType: Gender::class)]
    private Gender $gender;
    #[ORM\Column(type: 'int4range', nullable: true)]
    private ?Range $ageDaysRange = null;
    #[ORM\Column(nullable: true, enumType: PregnancyTrimester::class)]
    private ?PregnancyTrimester $pregnancyTrimester = null;
    #[ORM\Column(nullable: true, enumType: MenstrualPhase::class)]
    private ?MenstrualPhase $menstrualPhase = null;
    #[ORM\Column(type: 'jsonb')]
    private array $normalityRule;
    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $criticalityRule = null;
    #[ORM\Column(type: 'jsonb', nullable: true)]
    private ?array $interpretationRule = null;
    #[ORM\Column]
    private int $priority;

    public function __construct(TestDefinitionsDraftEntity $testDefinition, Gender $gender, array $normalityRule, int $priority)
    {
        $this->testDefinition = $testDefinition;
        $this->gender = $gender;
        $this->normalityRule = $normalityRule;
        $this->priority = $priority;
    }

    public function getTestDefinition(): TestDefinitionsDraftEntity
    {
        return $this->testDefinition;
    }

    public function setTestDefinition(TestDefinitionsDraftEntity $testDefinition): static
    {
        $this->testDefinition = $testDefinition;

        return $this;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function setGender(Gender $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getAgeDaysRange(): ?Range
    {
        return $this->ageDaysRange;
    }

    public function setAgeDaysRange(?Range $ageDaysRange): static
    {
        $this->ageDaysRange = $ageDaysRange;

        return $this;
    }

    public function getPregnancyTrimester(): ?PregnancyTrimester
    {
        return $this->pregnancyTrimester;
    }

    public function setPregnancyTrimester(?PregnancyTrimester $pregnancyTrimester): static
    {
        $this->pregnancyTrimester = $pregnancyTrimester;

        return $this;
    }

    public function getMenstrualPhase(): ?MenstrualPhase
    {
        return $this->menstrualPhase;
    }

    public function setMenstrualPhase(?MenstrualPhase $menstrualPhase): static
    {
        $this->menstrualPhase = $menstrualPhase;

        return $this;
    }

    public function getNormalityRule(): array
    {
        return $this->normalityRule;
    }

    public function setNormalityRule(array $normalityRule): static
    {
        $this->normalityRule = $normalityRule;

        return $this;
    }

    public function getCriticalityRule(): ?array
    {
        return $this->criticalityRule;
    }

    public function setCriticalityRule(?array $criticalityRule): static
    {
        $this->criticalityRule = $criticalityRule;

        return $this;
    }

    public function getInterpretationRule(): ?array
    {
        return $this->interpretationRule;
    }

    public function setInterpretationRule(?array $interpretationRule): static
    {
        $this->interpretationRule = $interpretationRule;

        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        if ($priority < 0) {
            throw new \InvalidArgumentException('Priority cannot be negative');
        }
        $this->priority = $priority;

        return $this;
    }
}
