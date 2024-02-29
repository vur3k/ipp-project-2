<?php

namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Variable;

class PushS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $val = $this->getArg(1);
        if ($val instanceof Variable) {
            $val = $val->getVarAsConst();
        }
        DataStack::pushData($val);
    }
}