<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;

class Move extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 2);
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);

        if ($arg1 instanceof Variable) {
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            elseif (!$arg2->isConst()) {
                exit(ReturnCode::OPERAND_TYPE_ERROR);
            }
            $arg1->setValue($arg2);
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}
