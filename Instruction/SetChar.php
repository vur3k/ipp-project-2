<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Frame\FrameStack;

class SetChar extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 3);
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);
        $arg3 = $this->getArg(3);

        if ($arg1 instanceof Variable) {
            $arg1 = FrameStack::findInScope($arg1->getName(), $arg1->getFrame());
            if (!$arg1->isAssigned()) {
                exit(ReturnCode::VALUE_ERROR);
            }
            if (!$arg1->isString()) {
                exit(ReturnCode::OPERAND_TYPE_ERROR);
            }
            $str = $arg1->getValue();
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            if ($arg3 instanceof Variable) {
                $arg3 = $arg3->getVarAsConst();
            }
            if ($arg2->isInt() && $arg3->isString()) {
                $index = $arg2->getValue();
                if ($index >= strlen($str) || $index < 0 || $arg3->getValue() === '') {
                    exit(ReturnCode::STRING_OPERATION_ERROR);
                }
                $str[$index] = $arg3->getValue()[0];
                $arg1->setValue(new Argument($str, 'string'));
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
