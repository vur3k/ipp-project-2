<?php

namespace IPP\Student\Instruction;

class Label extends AbstractInstruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }

    public function execute(): void {}
}
