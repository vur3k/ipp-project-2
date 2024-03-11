<?php

namespace IPP\Student\Frame;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;

class FrameStack {
    static private Frame $GF;
    /** @var Frame[] */
    static private array $LF;
    static private int $stackPointer;
    static private ?Frame $TF;

    static function init(): void {
        self::$GF = new Frame();
        self::$TF = null;
        self::$LF = [];
        self::$stackPointer = -1;
    }

    static public function createFrame(): void {
        self::$TF = new Frame();
    }

    static private function getStackPointer(): int {
        return self::$stackPointer;
    }

    static private function incrementStackPointer(): void {
        self::$stackPointer++;
    }

    static private function decrementStackPointer(): void {
        self::$stackPointer--;
    }
    static public function pushFrame(): void {
        if (!self::isTFInitialized()) {
            exit(ReturnCode::FRAME_ACCESS_ERROR);
        }
        self::incrementStackPointer();
        self::$LF[self::getStackPointer()] = self::$TF;
        self::$TF = null;
    }

    static public function popFrame(): void {
        if (self::isLFEmpty()) {
            exit(ReturnCode::FRAME_ACCESS_ERROR);
        }
        self::$TF = self::$LF[self::getStackPointer()];
        unset(self::$LF[self::getStackPointer()]);
        self::decrementStackPointer();
    }

    static public function findInScope(string $name, string $frame): Variable {
        $var = null;
        switch($frame) {
            case 'GF':
                $var = self::$GF->getVar($name);
                break;
            case 'LF':
                if (self::isLFEmpty()) {
                    exit(ReturnCode::FRAME_ACCESS_ERROR);
                }
                if (self::$LF[self::getStackPointer()]->isDefined($name)) {
                    $var = self::$LF[self::getStackPointer()]->getVar($name);
                    break;
                }
                break;
            case 'TF':
                if (!self::isTFInitialized()) {
                    exit(ReturnCode::FRAME_ACCESS_ERROR);
                }
                $var = self::$TF->getVar($name);
                break;
            default:
                exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        if ($var === null) {
            exit(ReturnCode::VARIABLE_ACCESS_ERROR);
        }
        return $var;
    }

    static public function isTFInitialized(): bool {
        return self::$TF !== null;
    }

    static public function isLFEmpty(): bool {
        return self::getStackPointer() === -1;
    }

    static public function getFrame(string $frameName): Frame {
        switch($frameName) {
            case 'GF':
                return self::$GF;
            case 'LF':
                if (self::isLFEmpty()) {
                    exit(ReturnCode::FRAME_ACCESS_ERROR);
                }
                return self::$LF[self::getStackPointer()];
            case 'TF':
                if (!self::isTFInitialized()) {
                    exit(ReturnCode::FRAME_ACCESS_ERROR);
                }
                return self::$TF;
            default:
                exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
    }
}
