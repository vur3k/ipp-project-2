<?php

namespace IPP\Student\Instruction;

use IPP\Core\Interface\OutputWriter;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;

class DPrint extends Instruction {
    static private OutputWriter $stderr;
    public function __construct(\DOMElement $instruction, OutputWriter $stderr) {
        parent::__construct($instruction, 1);
        self::$stderr = $stderr;
    }

    public function execute(): int {
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isConst()) {
            switch($arg->getType()) {
                case 'int':
                    self::$stderr->writeInt($arg->getValue());
                    break;
                case 'bool':
                    self::$stderr->writeBool($arg->getValue());
                    break;
                case 'string':
                case 'nil':
                    self::$stderr->writeString($arg->getValue());
                    break;
                case 'float':
                    self::$stderr->writeFloat($arg->getValue());
                    break;
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
        return parent::execute();
    }
}
