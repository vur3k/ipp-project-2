<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Argument;

class DataStack {
    /** @var Argument[] */
    static private array $stack;
    static private int $stackPointer = -1;

    static public function pushData(Argument $data): void {
        self::incrementStackPointer();
        self::$stack[self::getStackPointer()] = $data;
    }

    static public function popData(): Argument {
        if (self::isEmpty()) {
            exit(ReturnCode::VALUE_ERROR);
        }
        $top = self::$stack[self::getStackPointer()];
        unset(self::$stack[self::getStackPointer()]);
        self::decrementStackPointer();
        return($top);
    }

    static public function isEmpty(): bool {
        return self::getStackPointer() === -1;
    }

    static public function clearData(): void {
        while (!self::isEmpty()) {
            self::popData();
        }
    }

    static public function stackPeek(): ?Argument {
        if (self::isEmpty()) {
            return null;
        }
        return self::$stack[self::getStackPointer()];
    }

    static public function getStackPointer(): int {
        return self::$stackPointer;
    }

    static private function incrementStackPointer(): void {
        self::$stackPointer++;
    }

    static private function decrementStackPointer(): void {
        self::$stackPointer--;
    }
}
