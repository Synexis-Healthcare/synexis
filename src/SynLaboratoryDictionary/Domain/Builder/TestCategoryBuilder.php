<?php

declare(strict_types=1);

namespace App\SynLaboratoryDictionary\Domain\Builder;

use App\SynLaboratoryDictionary\Domain\Model\TestCategory;
use Symfony\Component\Uid\Uuid;

class TestCategoryBuilder
{
    private Uuid $id;
    private ?string $title = null;
    private ?string $mnemonic = null;

    public function __construct()
    {
        $this->id = Uuid::v7();
    }

    public function withId(Uuid $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function withTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function withMnemonic(string $mnemonic): self
    {
        $this->mnemonic = $mnemonic;

        return $this;
    }

    public static function from(TestCategory $category): self
    {
        return new self()
        ->withId($category->getId())
        ->withTitle($category->getTitle())
        ->withMnemonic($category->getMnemonic());
    }

    public function build(): TestCategory
    {
        if (null === $this->title || '' === trim($this->title)) {
            throw new \InvalidArgumentException('Category title is required');
        }
        if (null === $this->mnemonic || '' === trim($this->mnemonic)) {
            throw new \InvalidArgumentException('Category mnemonic is required');
        }

        return new TestCategory(
            $this->id,
            $this->title,
            $this->mnemonic
        );
    }
}
