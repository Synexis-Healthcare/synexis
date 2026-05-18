<?php

declare(strict_types=1);

namespace App\LaboratoryDictionary\Infrastructure\Doctrine\Entity;

use App\LaboratoryDictionary\Domain\Enum\UnitClassification;
use App\LaboratoryDictionary\Infrastructure\Doctrine\Repository\UnitEntityRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: UnitEntityRepository::class)]
#[ORM\Table(name: 'units', schema: 'laboratory_dictionary')]
class UnitEntity
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    private Uuid $id;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $code = null;

    #[ORM\Column(type: Types::TEXT, unique: true)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(enumType: UnitClassification::class)]
    private ?UnitClassification $classification = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
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

    public function getId(): Uuid
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getClassification(): ?UnitClassification
    {
        return $this->classification;
    }

    public function setClassification(UnitClassification $classification): static
    {
        $this->classification = $classification;

        return $this;
    }
}
