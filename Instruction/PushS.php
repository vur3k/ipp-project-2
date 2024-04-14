<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file PushS.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Variable;
use IPP\Student\DataStack;

/**
 * Class representing the PUSHS instruction
 */
class PushS extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {
        $val = $this->getArg(1);
        if ($val instanceof Variable) {
            $val = $val->getVarAsConst();
        }
        DataStack::pushData($val);
    }
}
