<?php

namespace IPP\Student\Instruction;

use IPP\Core\Interface\OutputWriter;
use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;
use IPP\Student\Frame\FrameStack;

class Write extends Instruction {
    static private OutputWriter $stdout;
    public function __construct(\DOMElement $instruction, OutputWriter $stdout) {
        parent::__construct($instruction, 1);
        self::$stdout = $stdout;
    }

    public function execute(): void {
        $arg = $this->getArg(1);
        if ($arg instanceof Variable) {

            $var = FrameStack::findInScope($arg->getName(), $arg->getFrame());
            if (!$var->isAssigned()) {
                exit(ReturnCode::VALUE_ERROR);
            }
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isConst()) {
            if ($arg->isNil()) {
                self::$stdout->writeString('');
            }
            elseif ($arg->isInt()) {
                self::$stdout->writeInt($arg->getValue());
            }
            elseif ($arg->isBool()) {
                self::$stdout->writeBool($arg->getValue());
            }
            else {
                self::$stdout->writeString($arg->getValue());
            }
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }
}
