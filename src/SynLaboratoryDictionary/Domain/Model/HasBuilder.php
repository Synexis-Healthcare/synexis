<?php

declare(strict_types=1);

namespace App\SynLaboratoryDictionary\Domain\Model;

trait HasBuilder
{
    public function toBuilder(): object
    {
        $modelClass = static::class;
        $builderClass = str_replace('\\Model\\', '\\Builder\\', $modelClass).'Builder';

        if (!class_exists($builderClass)) {
            throw new \InvalidArgumentException("Builder class {$builderClass} not found for model {$modelClass}");
        }

        return (new $builderClass())->fillFromModel($this);
    }
}
