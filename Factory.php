<?php

namespace IPP\Student;
use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;
use IPP\Core\ReturnCode;
use IPP\Student\Exception\InvalidSourceStructureException;

class Factory {
    static private int $instructionPointer;
    static private int $instructionExecutedCount = 0;

    static public function parseInstructions(\DOMElement $program, InputReader $stdin, OutputWriter $stdout, OutputWriter $stderr): void {
        $element = $program->firstElementChild;
        $instructions = [];

        for ($i = 0; $i < $program->childElementCount; $i++) {
            if ($element->localName !== 'instruction') {
                throw new InvalidSourceStructureException();
            }
            $order = (int)$element->getAttribute('order');
            if ($order < 1) {
                throw new InvalidSourceStructureException();
            }
            if (isset($instructions[$order])) {
                throw new InvalidSourceStructureException();
            }
            $instructions[$order] = $element;
            $element = $element->nextElementSibling;
        }

        ksort($instructions, SORT_NUMERIC);

        foreach ($instructions as $instruction) {
            $opcode = strtoupper($instruction->getAttribute('opcode'));
            switch ($opcode) {
                case "MOVE":
                    $tmp = new Instruction\Move($instruction);
                    break;
                case "PUSHFRAME":
                    $tmp = new Instruction\PushFrame($instruction);
                    break;
                case "POPFRAME":
                    $tmp = new Instruction\PopFrame($instruction);
                    break;
                case "CREATEFRAME":
                    $tmp = new Instruction\CreateFrame($instruction);
                    break;
                case "DEFVAR":
                    $tmp = new Instruction\DefVar($instruction);
                    break;
                case "CALL":
                    $tmp = new Instruction\Call($instruction);
                    break;
                case "RETURN":
                    $tmp = new Instruction\ReturnOp($instruction);
                    break;
                case "PUSHS":
                    $tmp = new Instruction\PushS($instruction);
                    break;
                case "POPS":
                    $tmp = new Instruction\PopS($instruction);
                    break;
                case "ADD":
                    $tmp = new Instruction\AddOp($instruction);
                    break;
                case "SUB":
                    $tmp = new Instruction\SubOp($instruction);
                    break;
                case "MUL":
                    $tmp = new Instruction\MulOp($instruction);
                    break;
                case "IDIV":
                    $tmp = new Instruction\IdivOp($instruction);
                    break;
                case "LT":
                    $tmp = new Instruction\LtOp($instruction);
                    break;
                case "GT":
                    $tmp = new Instruction\GtOp($instruction);
                    break;
                case "EQ":
                    $tmp = new Instruction\EqOp($instruction);
                    break;
                case "AND":
                    $tmp = new Instruction\AndOp($instruction);
                    break;
                case "OR":
                    $tmp = new Instruction\OrOp($instruction);
                    break;
                case "NOT":
                    $tmp = new Instruction\NotOp($instruction);
                    break;
                case "INT2CHAR":
                    $tmp = new Instruction\Int2Char($instruction);
                    break;
                case "STRI2INT":
                    $tmp = new Instruction\Stri2Int($instruction);
                    break;
                case "READ":
                    $tmp = new Instruction\Read($instruction, $stdin);
                    break;
                case "WRITE":
                    $tmp = new Instruction\Write($instruction, $stdout);
                    break;
                case "CONCAT":
                    $tmp = new Instruction\Concat($instruction);
                    break;
                case "STRLEN":
                    $tmp = new Instruction\StrLenOp($instruction);
                    break;
                case "GETCHAR":
                    $tmp = new Instruction\GetChar($instruction);
                    break;
                case "SETCHAR":
                    $tmp = new Instruction\SetChar($instruction);
                    break;
                case "TYPE":
                    $tmp = new Instruction\Type($instruction);
                    break;
                case "LABEL":
                    $tmp = new Instruction\Label($instruction);
                    break;
                case "JUMP":
                    $tmp = new Instruction\Jump($instruction);
                    break;
                case "JUMPIFEQ":
                    $tmp = new Instruction\JumpIfEq($instruction);
                    break;
                case "JUMPIFNEQ":
                    $tmp = new Instruction\JumpIfNeq($instruction);
                    break;
                case "EXIT":
                    $tmp = new Instruction\ExitOp($instruction);
                    break;
                case "DPRINT":
                    $tmp = new Instruction\DPrint($instruction, $stderr);
                    break;
                case "BREAK":
                    $tmp = new Instruction\BreakOp($instruction, $stderr);
                    break;
                case "ADDS":
                    $tmp = new Instruction\AddS($instruction);
                    break;
                case "ANDS":
                    $tmp = new Instruction\AndS($instruction);
                    break;
                case "CLEARS":
                    $tmp = new Instruction\ClearS($instruction);
                    break;
                case "EQS":
                    $tmp = new Instruction\EqS($instruction);
                    break;
                case "GTS":
                    $tmp = new Instruction\GtS($instruction);
                    break;
                case "IDIVS":
                    $tmp = new Instruction\IdivS($instruction);
                    break;
                case "INT2CHARS":
                    $tmp = new Instruction\Int2CharS($instruction);
                    break;
                case "JUMPIFEQS":
                    $tmp = new Instruction\JumpIfEqS($instruction);
                    break;
                case "JUMPIFNEQS":
                    $tmp = new Instruction\JumpIfNeqS($instruction);
                    break;
                case "LTS":
                    $tmp = new Instruction\LtS($instruction);
                    break;
                case "MULS":
                    $tmp = new Instruction\MulS($instruction);
                    break;
                case "NOTS":
                    $tmp = new Instruction\NotS($instruction);
                    break;
                case "ORS":
                    $tmp = new Instruction\OrS($instruction);
                    break;
                case "STRI2INTS":
                    $tmp = new Instruction\Stri2IntS($instruction);
                    break;
                case "SUBS":
                    $tmp = new Instruction\SubS($instruction);
                    break;
                case "DIV":
                    $tmp = new Instruction\DivOp($instruction);
                    break;
                case "FLOAT2INT":
                    $tmp = new Instruction\Float2Int($instruction);
                    break;
                case "INT2FLOAT":
                    $tmp = new Instruction\Int2Float($instruction);
                    break;
                default:
                    throw new InvalidSourceStructureException();
            }
            Instruction\InstructionList::insertInstructionToList($tmp);
        }
    }

    static private function incrementInstructionPointer(): void {
        self::$instructionPointer++;
    }

    static public function setInstructionPointer(int $line): void {
        self::$instructionPointer = $line;
    }

    static public function getExecutedCount(): int {
        return self::$instructionExecutedCount;
    }

    static private function incrementExecutedCount(): void {
        self::$instructionExecutedCount++;
    }

    static public function getInstructionPointer(): int {
        return self::$instructionPointer;
    }

    static public function executeInstructions(): int {
        $instructions = Instruction\InstructionList::getInstructionList();
        if (empty($instructions)) {
            return ReturnCode::OK;
        }
        self::setInstructionPointer(array_key_first($instructions));
        $lastLine = array_key_last($instructions);
        while (self::getInstructionPointer() <= $lastLine) {
            $curr = $instructions[self::getInstructionPointer()];
            if ($curr instanceof Instruction\ExitOp) {
                return $curr->execute();
            }
            $curr->execute();
            self::incrementInstructionPointer();
            self::incrementExecutedCount();
            while (!isset($instructions[self::getInstructionPointer()]) && self::getInstructionPointer() <= $lastLine) {
                self::incrementInstructionPointer();
            }
        }
        return ReturnCode::OK;
    }
}
