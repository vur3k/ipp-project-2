<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file PopS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the POPS instruction
 */
class PopS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $var = $this->getArg(1);
        if ($var instanceof Variable) {
            $var->setValue(DataStack::popData());
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
