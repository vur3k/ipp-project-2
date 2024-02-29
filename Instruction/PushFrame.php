<?php

namespace IPP\Student\Instruction;

use IPP\Student\Frame\FrameStack;

class PushFrame extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): void {
        FrameStack::pushFrame();
    }
}