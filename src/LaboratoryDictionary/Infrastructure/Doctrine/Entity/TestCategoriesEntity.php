<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\TestCategoriesEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TestCategoriesEntityRepository::class)]
#[ORM\Table(name: 'test_categories', schema: 'laboratory_dictionary')]
class TestCategoriesEntity
{
    #[ORM\Id]
    #[ORM\Column(type: Types::TEXT)]
    private string $mnemonic;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private string $title;

    public function __construct(string $mnemonic)
    {
        $this->mnemonic = $mnemonic;
    }

    public function getMnemonic(): string
    {
        return $this->mnemonic;
    }

    public function setMnemonic(string $mnemonic): static
    {
        $this->mnemonic = $mnemonic;

        return $this;
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
