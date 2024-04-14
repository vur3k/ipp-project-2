<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/Call.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\DataStack;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

/**
 * Class representing the CALL instruction
 */
class Call extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $val = $this->getArg(1);

        if (!$val->isLabel()) {
            throw new OperandTypeErrorException();
        }
        $label = InstructionList::getLabelLine($val->getValue());
        DataStack::pushData(new Argument($this->getOrder(), 'int'));
        Factory::setInstructionPointer($label);
    }
}
