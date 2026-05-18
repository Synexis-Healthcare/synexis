<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestProfilesEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestProfilesEntityRepository::class)]
#[ORM\Table(name: 'test_profiles', schema: 'laboratory_dictionary')]
class TestProfilesEntity
{
    #[ORM\Id]
    #[ORM\Column(type: Types::TEXT)]
    private string $code;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $title = null;
    #[ORM\ManyToMany(targetEntity: TestDefinitionsActiveEntity::class)]
    #[ORM\JoinTable(
        name: 'test_profile_test_definitions',
        schema: 'laboratory_dictionary',
        joinColumns: [new ORM\JoinColumn(name: 'profile_code', referencedColumnName: 'code')],
        inverseJoinColumns: [new ORM\JoinColumn(name: 'test_definition_id', referencedColumnName: 'id')]
    )]
    private Collection $testDefinitions;

    public function __construct(string $code)
    {
        $this->code = $code;
        $this->testDefinitions = new ArrayCollection();
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTestDefinitions(): Collection
    {
        return $this->testDefinitions;
    }

    public function addTestDefinition(TestDefinitionsActiveEntity $testDefinition): static
    {
        if (!$this->testDefinitions->contains($testDefinition)) {
            $this->testDefinitions->add($testDefinition);
        }

        return $this;
    }

    public function removeTestDefinition(TestDefinitionsActiveEntity $testDefinition): static
    {
        $this->testDefinitions->removeElement($testDefinition);

        return $this;
    }
}
