<?php

namespace IPP\Student\Instruction;

class Label extends Instruction {
    public function __construct(\DOMElement $instruction) {
        parent::__construct($instruction, 1);
    }
}