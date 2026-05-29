<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\Gender;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\ReferenceRulesDraftEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceRulesDraftEntityRepository::class)]
#[ORM\Table(
    name: 'reference_rules_draft',
    schema: 'laboratory_dictionary',
    options: [
        'check' => 'priority >= 0',
        'comment' => 'Contains EXCLUDE USING gist constraint for reference ambiguity',
    ]
)]
class ReferenceRulesDraftEntity extends ReferenceRulesEntity
{

    #[ORM\ManyToOne(targetEntity: TestDefinitionsDraftEntity::class, inversedBy: 'referenceRulesDraftEntity')]
    #[ORM\JoinColumn(name: 'test_definition_id', referencedColumnName: 'id', nullable: false)]
    private TestDefinitionsDraftEntity $testDefinition;


    public function __construct(
                                TestDefinitionsDraftEntity $testDefinition,
                                Gender $gender,
                                array $normalityRule,
                                int $priority)
    { parent::__construct(

        $gender,
        $normalityRule,
        $priority
    );
        $this->testDefinition = $testDefinition;
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



}
