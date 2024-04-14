<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student
 * @file Interpreter.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student;

use IPP\Core\AbstractInterpreter;
use IPP\Core\Exception\XMLException;
use IPP\Student\Exception\InvalidSourceStructureException;
use IPP\Student\Frame\FrameStack;
use IPP\Core\Interface as Iface;

/**
 * IPPCode24 language interpreter entry point
 */
class Interpreter extends AbstractInterpreter {
    private function getInput(): Iface\InputReader {
        return $this->input;
    }

    private function getStdout(): Iface\OutputWriter {
        return $this->stdout;
    }

    private function getStderr(): Iface\OutputWriter {
        return $this->stderr;
    }

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
        Factory::parseInstructions($program, $this->getInput(), $this->getStdout(), $this->getStderr());
        return Factory::executeInstructions();
    }
}
