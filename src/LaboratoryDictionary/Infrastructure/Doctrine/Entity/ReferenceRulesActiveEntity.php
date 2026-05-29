<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\Gender;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\ReferenceRulesActiveEntityRepository;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReferenceRulesActiveEntityRepository::class)]
#[ORM\Table(
    name: 'reference_rules_active',
    schema: 'laboratory_dictionary',
    options: [
        'check' => 'priority >= 0',
        'comment' => 'Contains EXCLUDE USING gist constraint for reference ambiguity',
    ]
)]
class ReferenceRulesActiveEntity extends ReferenceRulesEntity
{

    #[ORM\ManyToOne(targetEntity: TestDefinitionsActiveEntity::class, inversedBy: 'referenceRulesActive')]
    #[ORM\JoinColumn(name: 'test_definition_active_id', referencedColumnName: 'id', nullable: false)]
    private TestDefinitionsActiveEntity $testDefinitionActive;


    public function __construct(
                                 TestDefinitionsActiveEntity $testDefinitionActive,  Gender $gender,
                                 array $normalityRule,
                                 int $priority)
    {
        parent:: __construct(
            $gender,
            $normalityRule,
            $priority
        );
        $this->testDefinitionActive = $testDefinitionActive;

    }

    public function getTestDefinition(): TestDefinitionsActiveEntity
    {
        return $this->testDefinitionActive;
    }

    public function setTestDefinition(TestDefinitionsActiveEntity $testDefinitionActive): static
    {
        $this->testDefinitionActive = $testDefinitionActive;

        return $this;
    }



}
