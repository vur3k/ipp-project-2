<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

class PopS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $var = $this->getArg(1);
        if ($var instanceof Variable) {
            $var->setValue(DataStack::popData());
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
