<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file Jump.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Factory;

/**
 * Class representing the JUMP instruction
 */
class Jump extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $label = $this->getArg(1);

        if (!$label->isLabel()){
            throw new OperandTypeErrorException();
        }
        Factory::setInstructionPointer(InstructionList::getLabelLine($label->getValue()));
    }
}
