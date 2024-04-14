<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/Int2Float.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the INT2FLOAT instruction
 */
class Int2Float extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 2);
    }

    public function execute(): void {
        $arg1 = $this->getArg(1);
        $arg2 = $this->getArg(2);

        if ($arg1 instanceof Variable) {
            if ($arg2 instanceof Variable) {
                $arg2 = $arg2->getVarAsConst();
            }
            if ($arg2->isInt()) {
                $arg1->setValue(new Argument((float)$arg2->getValue(), 'float'));
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
