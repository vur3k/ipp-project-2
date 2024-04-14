<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file BreakOp.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Factory;
use IPP\Student\Frame\FrameStack;
use IPP\Core\Interface\OutputWriter;

/**
 * Class representing the BREAK instruction
 */
class BreakOp extends AbstractInstruction {
    static private OutputWriter $stderr;
    public function __construct(\DOMElement $instruction, OutputWriter $stderr) {
        parent::__construct($instruction, 0);
        self::$stderr = $stderr;
    }

    public function execute(): void {
        $currOrder = Factory::getInstructionPointer();
        self::$stderr->writeString("#########################################################################\n");
        self::$stderr->writeString("Instruction pointer: $currOrder\n\n");
        if (FrameStack::isTFInitialized()) {
            $TF = print_r(FrameStack::getFrame('TF'), true);
            self::$stderr->writeString("TF Contents:\n$TF\n");
        }
        if (!FrameStack::isLFEmpty()) {
            $LF = print_r(FrameStack::getFrame('LF'), true);
            self::$stderr->writeString("LF Contents:\n$LF\n");
        }
        $GF = print_r(FrameStack::getFrame('GF'), true);
        self::$stderr->writeString("GF Contents:\n$GF\n");
        $top = print_r(DataStack::stackPeek(), true);
        self::$stderr->writeString("On top of the DATA STACK: $top\n");
        $cnt = DataStack::getStackPointer() + 1;
        self::$stderr->writeString("$cnt items in the DATA STACK\n");
        $executed = Factory::getExecutedCount();
        self::$stderr->writeString("$executed executed instructions\n");
        self::$stderr->writeString("#########################################################################\n");
    }
}
