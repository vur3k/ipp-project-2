<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\DataStack;
use IPP\Student\Variable;

class PopS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $var = $this->getArg(1);
        if ($var instanceof Variable) {
            $var->setValue(DataStack::popData());
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}