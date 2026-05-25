<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestCategoriesEntityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestCategoriesEntityRepository::class)]
#[ORM\Table(name: 'test_categories', schema: 'laboratory_dictionary')]
class TestCategoriesEntity
{
    #[ORM\Id]
    #[ORM\Column(type: Types::TEXT)]
    public readonly string $mnemonic;
    #[ORM\OneToMany(targetEntity: TestDefinitionsDraftEntity::class, mappedBy: 'categoryMnemonic')]
    private Collection $testDefinitions;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $title;

    public function __construct(string $mnemonic, string $title)
    {
        $this->mnemonic = $mnemonic;
        $this->title = $title;
        $this->testDefinitions = new ArrayCollection();
    }

    public function getTestDefinitions(): array
    {
        return $this->testDefinitions->toArray();
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }
}
