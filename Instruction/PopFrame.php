<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/PopFrame.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Frame\FrameStack;

/**
 * Class representing the POPFRAME instruction
 */
class PopFrame extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        FrameStack::popFrame();
    }
}
