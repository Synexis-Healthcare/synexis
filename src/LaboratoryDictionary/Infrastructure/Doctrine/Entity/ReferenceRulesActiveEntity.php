<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\Gender;
use App\LaboratoryDictionary\Domain\Enum\MenstrualPhase;
use App\LaboratoryDictionary\Domain\Enum\PregnancyTrimester;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\ReferenceRulesActiveEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use MartinGeorgiev\Doctrine\DBAL\Types\ValueObject\Range;

#[ORM\Entity(repositoryClass: ReferenceRulesActiveEntityRepository::class)]
#[ORM\Table(
    name: 'reference_rules_active',
    schema: 'laboratory_dictionary',
    options: [
        'check' => 'priority >= 0',
        'comment' => 'Contains EXCLUDE USING gist constraint for reference ambiguity',
    ]
)]
class ReferenceRulesActiveEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: TestDefinitionsActiveEntity::class, inversedBy: 'referenceRulesActiveEntity')]
    #[ORM\JoinColumn(name: 'test_definition_active_id', referencedColumnName: 'id', nullable: false)]
    private ?TestDefinitionsActiveEntity $test_definition_active_id = null;

    #[ORM\Column(enumType: Gender::class)]
    private ?Gender $gender = null;

    #[ORM\Column(type: 'int4range', nullable: true)]
    private ?Range $age_days_range = null;

    #[ORM\Column(nullable: true, enumType: PregnancyTrimester::class)]
    private ?PregnancyTrimester $pregnancy_trimester = null;

    #[ORM\Column(enumType: MenstrualPhase::class, nullable: true)]
    private ?MenstrualPhase $menstrual_phase = null;

    #[ORM\Column(type: Types::JSONB, options: ['jsonb' => true])]
    private $normality_rule;

    #[ORM\Column(type: Types::JSONB, options: ['jsonb' => true], nullable: true)]
    private $criticality_rule;

    #[ORM\Column(type: Types::JSONB, options: ['jsonb' => true], nullable: true)]
    private $interpretation_rule;

    #[ORM\Column]
    private ?int $priority = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTestDefinitionId(): ?TestDefinitionsActiveEntity
    {
        return $this->test_definition_active_id;
    }

    public function setTestDefinitionId(?TestDefinitionsActiveEntity $test_definition_active_id): static
    {
        $this->test_definition_active_id = $test_definition_active_id;

        return $this;
    }

    public function getGender(): ?Gender
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
        return $this->age_days_range;
    }

    public function setAgeDaysRange(?Range $age_days_range): static
    {
        $this->age_days_range = $age_days_range;

        return $this;
    }

    public function getPregnancyTrimester(): ?PregnancyTrimester
    {
        return $this->pregnancy_trimester;
    }

    public function setPregnancyTrimester(?PregnancyTrimester $pregnancy_trimester): static
    {
        $this->pregnancy_trimester = $pregnancy_trimester;

        return $this;
    }

    public function getMenstrualPhase(): ?MenstrualPhase
    {
        return $this->menstrual_phase;
    }

    public function setMenstrualPhase(MenstrualPhase $menstrual_phase): static
    {
        $this->menstrual_phase = $menstrual_phase;

        return $this;
    }

    public function getNormalityRule()
    {
        return $this->normality_rule;
    }

    public function setNormalityRule($normality_rule): static
    {
        $this->normality_rule = $normality_rule;

        return $this;
    }

    public function getCriticalityRule()
    {
        return $this->criticality_rule;
    }

    public function setCriticalityRule($criticality_rule): static
    {
        $this->criticality_rule = $criticality_rule;

        return $this;
    }

    public function getInterpretationRule()
    {
        return $this->interpretation_rule;
    }

    public function setInterpretationRule($interpretation_rule): static
    {
        $this->interpretation_rule = $interpretation_rule;

        return $this;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;

        return $this;
    }
}
