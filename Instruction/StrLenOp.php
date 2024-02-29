<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument;
use IPP\Student\Variable;

class StrLenOp extends Instruction {
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
            if($arg2->isString()) {
                $res = strlen($arg2->getValue());
                $arg1->setValue(new Argument($res, 'int'));
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