<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/NotS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;

/**
 * Class representing the NOTS instruction
 */
class NotS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        $arg1 = DataStack::popData();
        if ($arg1->isBool()) {
            DataStack::pushData(new Argument(!$arg1->getValue() ? 'true' : 'false', 'bool'));
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
