<?php

namespace IPP\Student\Frame;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;

class Frame {
    /**
     * @var Variable[]
     */
    private array $variables;
    public function __construct() {
        $this->variables = array();
    }

    public function defVar(Variable $var): void {
        if ($this->isDefined($var->getName())){
            exit(ReturnCode::SEMANTIC_ERROR);
        }
        $this->variables[$var->getName()] = $var;
    }

    public function updateVar(Variable $var): void {
        if (!$this->isDefined($var->getName())) {
            exit(ReturnCode::FRAME_ACCESS_ERROR);
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
        exit(ReturnCode::VARIABLE_ACCESS_ERROR);
    }
}