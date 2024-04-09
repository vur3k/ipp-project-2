<?php

namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\OperandValueErrorException;

class ExitOp extends AbstractInstruction {
    private int $retVal;
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isInt()) {
            $this->setRetVal($arg->getValue());
        }
        else {
            throw new OperandTypeErrorException();
        }
    }

    private function setRetVal(int $code): void {
        if ($code < 0 || $code > 9) {
            throw new OperandValueErrorException();
        }
        $this->retVal = $code;
    }

    public function getRetVal(): int {
        return $this->retVal;
    }
}
