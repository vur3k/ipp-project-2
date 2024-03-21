<?php

namespace IPP\Student\Instruction;

use IPP\Student\DataStack;

class ClearS extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 0);
    }

    public function execute(): int {
        DataStack::clearData();
        return parent::execute();
    }
}
