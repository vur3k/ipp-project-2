<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/ExitOp.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\OperandValueErrorException;

/**
 * Class representing the EXIT instruction
 */
class ExitOp extends AbstractInstruction {
    private int $retVal;
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $arg = $arg->getVarAsConst();
        }
        if ($arg->isInt()) {
            $this->setRetVal($arg->getValue());
        }
        else {
            throw new OperandTypeErrorException();
        }
    }

    private function setRetVal(int $code): void {
        if ($code < 0 || $code > 9) {
            throw new OperandValueErrorException();
        }
        $this->retVal = $code;
    }

    public function getRetVal(): int {
        return $this->retVal;
    }
}
