<?php

namespace IPP\Student\Frame;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\SemanticErrorException;
use IPP\Student\Exception\VariableAccessErrorException;

class Frame {
    /** @var Variable[] */
    private array $variables = [];

    public function defVar(Variable $var): void {
        if ($this->isDefined($var->getName())) {
            throw new SemanticErrorException();
        }
        $this->variables[$var->getName()] = $var;
    }

    public function isDefined(string $name): bool {
        return isset($this->variables[$name]);
    }

    public function getVar(string $name): Variable {
        if ($this->isDefined($name)) {
            return $this->variables[$name];
        }
        throw new VariableAccessErrorException();
    }
}
