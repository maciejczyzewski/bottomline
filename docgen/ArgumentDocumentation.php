<?php

namespace __\DocGen;

use Exception;
use JsonSerializable;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use phpDocumentor\Reflection\Type;
use ReflectionParameter;

class ArgumentDocumentation implements JsonSerializable
{
    public string $name;

    public string $description;

    public bool $isVariadic;

    public Type $type;

    public mixed $defaultValue;

    public ?string $defaultValueAsString;

    public function __construct(Param $documentedParam, ReflectionParameter $reflectedParam = null)
    {
        $this->name = $documentedParam->getVariableName();
        $this->description = $documentedParam->getDescription()->render();
        $this->isVariadic = $documentedParam->isVariadic();
        $this->type = $documentedParam->getType();
        $this->defaultValue = null;
        $this->defaultValueAsString = null;

        if ($reflectedParam !== null && $reflectedParam->isOptional()) {
            try {
                $defaultValue = $reflectedParam->getDefaultValue();
                $this->defaultValue = $defaultValue;
                if ($defaultValue === null) {
                    $this->defaultValueAsString = 'null';
                } elseif (is_bool($defaultValue)) {
                    $this->defaultValueAsString = $defaultValue ? 'true' : 'false';
                } elseif (is_string($defaultValue)) {
                    $this->defaultValueAsString = sprintf("'%s'", $defaultValue);
                } elseif (is_array($defaultValue)) {
                    $this->defaultValueAsString = '[]';
                } else {
                    $this->defaultValueAsString = $defaultValue;
                }
            } catch (Exception $e) {
            }
        }
    }

    /**
     * @see Method
     */
    public function getMethodArgumentDefinition(): array
    {
        return [
            'name' => $this->getSignature(),
            'type' => $this->type,
        ];
    }

    public function getSignature(): string
    {
        if ($this->defaultValueAsString) {
            return "{$this->name} = {$this->defaultValueAsString}";
        }
        if ($this->isVariadic) {
            return "{$this->name},...";
        }

        return $this->name;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'name' => $this->name,
            'isVariadic' => $this->isVariadic,
            'description' => $this->description,
            'defaultValue' => $this->defaultValue,
            'defaultValueAsString' => $this->defaultValueAsString,
            'type' => (string)$this->type,
        ];
    }
}
