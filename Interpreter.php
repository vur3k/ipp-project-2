<?php

namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\ReturnCode;
use IPP\Student\Frame\FrameStack;

class Interpreter extends AbstractInterpreter {
    public function execute(): int {
        $dom = $this->source->getDOMDocument();
        if ($dom->firstChild !== $dom->lastChild) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        $program = $dom->firstElementChild;
        if ($program->localName !== 'program') {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        if ($program->getAttribute('language') !== 'IPPcode24') {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        FrameStack::init();
        Factory::parseInstructions($program, $this->input, $this->stdout, $this->stderr);
        Factory::executeInstructions();
    return ReturnCode::OK;
    }
}
