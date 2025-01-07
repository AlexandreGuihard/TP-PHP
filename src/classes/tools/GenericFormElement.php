<?php

declare(strict_types=1);

namespace tools;
abstract class GenericFormElement implements InputRenderInterface
{
    protected string $type;

    protected bool $required = false;

    protected mixed $value = '';

    protected string $label;

    public function __construct(protected readonly string $name, $required=false, string $defaultValue='', string $label='')
    {
        $this->required = $required;
        $this->value = $defaultValue;
        $this->label=$label;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    function getId(): string 
    {
        return sprintf('form_%s', $this->name);
    }

    function getName(): string 
    {
        return $this->name;
    }

    function getValue(): array|string 
    {
        return $this->value;
    }

    function isRequired(): bool
    {
        return $this->required;
    }

    function getLabel(): string{
        return $this->label;
    }
}
?>