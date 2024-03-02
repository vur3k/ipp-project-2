<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;
use IPP\Student\Frame\FrameStack;

class DefVar extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $arg = $this->getArg(1);
        if ($arg instanceof Variable) {
            $frame = FrameStack::getFrame($arg->getFrame());
            if (!$frame->isDefined($arg->getName())) {
                $frame->defVar($arg);
            }
            else {
                exit(ReturnCode::SEMANTIC_ERROR);
            }
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }

    }
}