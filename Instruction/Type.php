<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Frame\FrameStack;

class Type extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 2);
    }

    public function execute(): int {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);

        if ($arg1 instanceof Variable) {
            if ($arg2 instanceof Variable) {
                $arg2 = FrameStack::findInScope($arg2->getName(), $arg2->getFrame());
                if ($arg2->isAssigned()) {
                    $arg1->setValue(new Argument($arg2->getVarType(), 'string'));
                }
                else {
                    $arg1->setValue(new Argument('', 'string'));
                }
            }
            elseif ($arg2->isConst()) {
                $arg1->setValue(new Argument($arg2->getType(), 'string'));
            }
            else {
                throw new OperandTypeErrorException();
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
