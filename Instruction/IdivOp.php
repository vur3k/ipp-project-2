<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\OperandValueErrorException;

class IdivOp extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 3);
    }
    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);
        $arg3 = $this->getArg(3);

        if ($arg1 instanceof Variable) {
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            if ($arg3 instanceof Variable) {
                $arg3 = $arg3->getVarAsConst();
            }
            if ($arg2->isInt() && $arg3->isInt()) {
                if($arg3->getValue() === 0) {
                    throw new OperandValueErrorException();
                }
                $arg1->setValue(new Argument(intdiv($arg2->getValue(), $arg3->getValue()), 'int'));
            }
            else {
                throw new OperandTypeErrorException();
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
