<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file SetChar.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\StringOperationErrorException;
use IPP\Student\Exception\ValueErrorException;
use IPP\Student\Frame\FrameStack;

/**
 * Class representing the SETCHAR instruction
 */
class SetChar extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 3);
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);
        $arg3 = $this->getArg(3);

        if ($arg1 instanceof Variable) {
            $arg1 = FrameStack::findInScope($arg1->getName(), $arg1->getFrame());
            if (!$arg1->isAssigned()) {
                throw new ValueErrorException();
            }
            if (!$arg1->isString()) {
                throw new OperandTypeErrorException();
            }
            $str = $arg1->getValue();
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            if ($arg3 instanceof Variable) {
                $arg3 = $arg3->getVarAsConst();
            }
            if ($arg2->isInt() && $arg3->isString()) {
                $index = $arg2->getValue();
                if ($index >= strlen($str) || $index < 0 || $arg3->getValue() === '') {
                    throw new StringOperationErrorException();
                }
                $str[$index] = $arg3->getValue()[0];
                $arg1->setValue(new Argument($str, 'string'));
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
