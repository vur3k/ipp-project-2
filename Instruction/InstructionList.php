<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;

class InstructionList {
    /**
     * @var Instruction[]
     */
    static private array $instructionList = [];
    /**
     * @var int[]
     */
    static private array $labelList = [];

    static public function insertInstructionToList(Instruction $instruction): void {
        if (isset(self::$instructionList[$instruction->getOrder()])) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        if ($instruction instanceof Label) {
            self::insertLabelToList($instruction);
        }
        self::$instructionList[$instruction->getOrder()] = $instruction;
    }

    static private function insertLabelToList(Instruction $instruction): void {
        if ($instruction->getArgCnt() !== 1) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        $label = $instruction->getArg(1);
        if (!$label->isLabel()) {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
        if (isset(self::$labelList[$label->getValue()])) {
            exit(ReturnCode::SEMANTIC_ERROR);
        }
        self::$labelList[$label->getValue()] = $instruction->getOrder();
    }

    /**
     * @return Instruction[]
     */
    static public function getInstructionList(): array {
        return self::$instructionList;
    }

    static public function getLabelLine(string $label): int {
        if (isset(self::$labelList[$label])) {
            return self::$labelList[$label];
        }
        exit(ReturnCode::SEMANTIC_ERROR);
    }
}
