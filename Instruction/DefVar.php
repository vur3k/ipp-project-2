<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/DefVar.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\SemanticErrorException;
use IPP\Student\Frame\FrameStack;

/**
 * Class representing the DEFVAR instruction
 */
class DefVar extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $arg = $this->getArg(1);

        if ($arg instanceof Variable) {
            $frame = FrameStack::getFrame($arg->getFrame());
            if (!$frame->isDefined($arg->getName())) {
                $frame->defVar($arg);
            }
            else {
                throw new SemanticErrorException();
            }
        }
        else {
            throw new OperandTypeErrorException();
        }
    }
}
