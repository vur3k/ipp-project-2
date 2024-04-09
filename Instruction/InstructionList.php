<?php

namespace IPP\Student\Instruction;

use IPP\Student\Exception\InvalidSourceStructureException;
use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\SemanticErrorException;

class InstructionList {
    /** @var AbstractInstruction[] */
    static private array $instructionList = [];
    /** @var int[] */
    static private array $labelList = [];

    static public function insertInstructionToList(AbstractInstruction $instruction): void {
        if (isset(self::$instructionList[$instruction->getOrder()])) {
            throw new InvalidSourceStructureException();
        }
        if ($instruction instanceof Label) {
            self::insertLabelToList($instruction);
        }
        self::$instructionList[$instruction->getOrder()] = $instruction;
    }

    static private function insertLabelToList(AbstractInstruction $instruction): void {
        if ($instruction->getArgCnt() !== 1) {
            throw new InvalidSourceStructureException();
        }
        $label = $instruction->getArg(1);
        if (!$label->isLabel()) {
            throw new OperandTypeErrorException();
        }
        if (isset(self::$labelList[$label->getValue()])) {
            throw new SemanticErrorException();
        }
        self::$labelList[$label->getValue()] = $instruction->getOrder();
    }

    /** @return AbstractInstruction[] */
    static public function getInstructionList(): array {
        return self::$instructionList;
    }

    static public function getLabelLine(string $label): int {
        if (isset(self::$labelList[$label])) {
            return self::$labelList[$label];
        }
        throw new SemanticErrorException();
    }
}
