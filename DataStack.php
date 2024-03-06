<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;

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

    static function stackPeek(): ?Argument {
        if (self::isEmpty()) {
            return null;
        }
        return self::$stack[self::getStackPointer()];
    }

    static function getStackPointer(): int {
        return self::$stackPointer;
    }

    private static function incrementStackPointer(): void {
        self::$stackPointer++;
    }

    private static function decrementStackPointer(): void {
        self::$stackPointer--;
    }
}
