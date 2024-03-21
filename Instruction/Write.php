<?php

namespace IPP\Student\Instruction;

use IPP\Core\Interface\OutputWriter;
use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\ValueErrorException;
use IPP\Student\Frame\FrameStack;

class Write extends Instruction {
    static private OutputWriter $stdout;
    public function __construct(\DOMElement $instruction, OutputWriter $stdout) {
        parent::__construct($instruction, 1);
        self::$stdout = $stdout;
    }

    public function execute(): int {
        $arg = $this->getArg(1);
        if ($arg instanceof Variable) {

            $var = FrameStack::findInScope($arg->getName(), $arg->getFrame());
            if (!$var->isAssigned()) {
                throw new ValueErrorException();
            }
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isConst()) {
            if ($arg->isString() || $arg->isNil()) {
                self::$stdout->writeString($arg->getValue());
            }
            elseif ($arg->isInt()) {
                self::$stdout->writeInt($arg->getValue());
            }
            elseif ($arg->isBool()) {
                self::$stdout->writeBool($arg->getValue());
            }
            elseif ($arg->isFloat()) {
                self::$stdout->writeFloat($arg->getValue());
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
