<?php

namespace IPP\Student\Instruction;

use IPP\Student\Frame\FrameStack;

class PopFrame extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        FrameStack::popFrame();
        return parent::execute();
    }
}
