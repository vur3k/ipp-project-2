<?php

namespace IPP\Student\Instruction;

use IPP\Student\DataStack;
use IPP\Student\Factory;
use IPP\Student\Frame\FrameStack;
use IPP\Core\Interface\OutputWriter;

class BreakOp extends Instruction {
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
        $Stack = print_r(DataStack::getStack(), true);
        self::$stderr->writeString("DATA STACK Contents:\n$Stack\n");
        $executed = Factory::getExecutedCount();
        self::$stderr->writeString("Executed instruction count: $executed\n");
        self::$stderr->writeString("#########################################################################\n");
    }
}