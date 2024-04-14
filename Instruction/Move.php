<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/Move.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the MOVE instruction
 */
class Move extends AbstractInstruction {
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
            elseif (!$arg2->isConst()) {
                throw new OperandTypeErrorException();
            }
            $arg1->setValue($arg2);
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
