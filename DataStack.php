<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;

class DataStack {
    /**
     * @var Argument[]
     */
    private static array $stack;
    private static int $stackPointer = -1;

    static function pushData(Argument $data): void {
        self::incrementStackPointer();
        self::$stack[self::getStackPointer()] = $data;
    }

    static function popData(): Argument {
        if (self::isEmpty()) {
            exit(ReturnCode::VALUE_ERROR);
        }
        $top = self::$stack[self::getStackPointer()];
        unset(self::$stack[self::getStackPointer()]);
        self::decrementStackPointer();
        return($top);
    }

    static function isEmpty(): bool {
        return self::getStackPointer() === -1;
    }

    static function clearData(): void {
        while (!self::isEmpty()) {
            self::popData();
        }
    }

    /**
     * @return Argument[]
     */
    static function getStack(): array {
        return DataStack::$stack;
    }

    static function getStackPointer(): int {
        return self::$stackPointer;
    }

    static function incrementStackPointer(): void {
        self::$stackPointer++;
    }

    static function decrementStackPointer(): void {
        self::$stackPointer--;
    }
}