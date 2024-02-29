<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument;
use IPP\Student\Variable;

class Int2Char extends Instruction {
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
            if ($arg2->isInt()) {
                $char = mb_chr($arg2->getValue(), 'UTF-8');
                if (!$char) {
                    exit(ReturnCode::STRING_OPERATION_ERROR);
                }
                $arg1->setValue(new Argument($char, 'string'));
            }
            else {
                exit(ReturnCode::OPERAND_TYPE_ERROR);
            }
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}