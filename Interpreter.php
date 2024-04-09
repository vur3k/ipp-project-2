<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\XMLException;
use IPP\Student\Exception\InvalidSourceStructureException;
use IPP\Student\Frame\FrameStack;

class Interpreter extends AbstractInterpreter {
    public function execute(): int {
        try {
            $dom = $this->source->getDOMDocument();
        }
        catch (\ValueError) {
            throw new XMLException();
        }

        if ($dom->firstChild !== $dom->lastChild) {
            throw new InvalidSourceStructureException();
        }
        $program = $dom->firstElementChild;
        if ($program->localName !== 'program') {
            throw new InvalidSourceStructureException();
        }
        if ($program->getAttribute('language') !== 'IPPcode24') {
            throw new InvalidSourceStructureException();
        }
        FrameStack::init();
        Factory::parseInstructions($program, $this->input, $this->stdout, $this->stderr);
        return Factory::executeInstructions();
    }
}
