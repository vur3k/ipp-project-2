<?php

namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;

class InstructionList {
    /**
     * @var Instruction[]
     */
    private static array $instructionList = [];
    /**
     * @var int[]
     */
    private static array $labelList = [];

    public static function insertInstructionToList(Instruction $instruction): void {
        if (isset(self::$instructionList[$instruction->getOrder()])) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        if ($instruction instanceof Label) {
            self::insertLabelToList($instruction);
        }
        self::$instructionList[$instruction->getOrder()] = $instruction;
    }

    private static function insertLabelToList(Instruction $instruction): void {
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
    public static function getInstructionList(): array {
        return self::$instructionList;
    }

    public static function getLabelLine(string $label): int {
        if (isset(self::$labelList[$label])) {
            return self::$labelList[$label];
        }
        exit(ReturnCode::SEMANTIC_ERROR);
    }
}