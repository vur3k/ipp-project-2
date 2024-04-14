<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file Stri2Int.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\StringOperationErrorException;

/**
 * Class representing the STRI2INT instruction
 */
class Stri2Int extends AbstractInstruction {
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
            if ($arg2->isString() && $arg3->isInt()) {
                if ($arg3->getValue() >= strlen($arg2->getValue()) || $arg3->getValue() < 0) {
                    throw new StringOperationErrorException();
                }
                $ord = mb_ord($arg2->getValue()[$arg3->getValue()], 'UTF-8');
                if (!$ord) {
                    throw new StringOperationErrorException();
                }
                $arg1->setValue(new Argument($ord, 'int'));
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
