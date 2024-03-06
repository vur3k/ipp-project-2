<?php

namespace IPP\Student\Instruction;

use IPP\Core\Interface\InputReader;
use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;

class Read extends Instruction {
    static private InputReader $input;
    public function __construct(\DOMElement $instruction, InputReader $stdin) {
        parent::__construct($instruction, 2);
        self::$input = $stdin;
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);
        if ($arg1 instanceof Variable) {
            if ($this->getArg(2)->isType()) {
                switch($arg2->getValue()) {
                    case 'int':
                        $val = self::$input->readInt();;
                        if ($val !== null) {
                            $arg1->setValue(new Argument($val, 'int'));
                        }
                        else {
                            $arg1->setValue(new Argument('', 'nil'));
                        }
                        break;
                    case 'bool':
                        $val = self::$input->readBool();
                        if ($val !== null) {
                            $arg1->setValue(new Argument($val ? 'true' : 'false', 'bool'));
                        }
                        else {
                            $arg1->setValue(new Argument('', 'nil'));
                        }
                        break;
                    case 'string':
                        $val = self::$input->readString();
                        if ($val !== null) {
                            $arg1->setValue(new Argument($val, 'string'));
                        }
                        else {
                            $arg1->setValue(new Argument('', 'nil'));
                        }
                        break;
                    case 'float':
                        $val = self::$input->readFloat();
                        if ($val !== null) {
                            $arg1->setValue(new Argument($val, 'float'));
                        }
                        else {
                            $arg1->setValue(new Argument('', 'nil'));
                        }
                        break;
                }
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
