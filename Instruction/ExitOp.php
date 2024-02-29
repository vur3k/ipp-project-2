<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument;
use IPP\Student\Variable;

class ExitOp extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        /**
         * @var Variable|Argument $arg
         */
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isInt()) {
            if ($arg->getValue() >= 0 && $arg->getValue() <= 9) {
                exit($arg->getValue());
            }
            exit(ReturnCode::OPERAND_VALUE_ERROR);
        }
        exit(ReturnCode::OPERAND_TYPE_ERROR);
    }
}