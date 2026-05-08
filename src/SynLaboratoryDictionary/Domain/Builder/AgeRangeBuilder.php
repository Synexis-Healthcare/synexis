<?php

declare(strict_types=1);

namespace App\SynLaboratoryDictionary\Domain\Builder;

use App\SynLaboratoryDictionary\Domain\Enum\AgeUnit;
use App\SynLaboratoryDictionary\Domain\Model\AgeRange;

class AgeRangeBuilder
{
    private int $min = 0;
    private ?int $max = null;
    private AgeUnit $unit = AgeUnit::DAYS;

    public function withMin(int $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function withMax(?int $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function withUnit(AgeUnit $unit): self
    {
        $this->unit = $unit;

        return $this;
    }

    public static function from(AgeRange $ageRange): self
    {
        return new self()
        ->withMin($ageRange->getMin())
        ->withMax($ageRange->getMax())
        ->withUnit($ageRange->getUnit());
    }

    public function build(): AgeRange
    {
        if ($this->min < 0) {
            throw new \InvalidArgumentException('Min age cannot be negative');
        }

        if (null !== $this->max && $this->max < $this->min) {
            throw new \InvalidArgumentException('Age range maximum must be greater than or equal to minimum');
        }

        return new AgeRange(
            $this->min,
            $this->max,
            $this->unit
        );
    }
}
