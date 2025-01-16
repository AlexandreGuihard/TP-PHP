<?php
declare(strict_types=1);

namespace tools\type;
use tools\GenericFormElement;
final class Textarea extends GenericFormElement
{
    public function render(): string
    {
        return sprintf(
            '<textarea name="form[%s]" %s id="%s" label=%s>%s</textarea>', 
            $this->getName(),
            $this->isRequired() ? 'required="required"' : '',
            $this->getId(),
            $this->getLabel(),
            $this->getValue(),
        );
    }
}
?>