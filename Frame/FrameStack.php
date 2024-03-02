<?php

namespace IPP\Student\Frame;

use IPP\Core\ReturnCode;
use IPP\Student\Argument\Variable;

class FrameStack {
    private static Frame $GF;
    /**
     * @var Frame[]
     */
    private static array $LF;
    private static int $stackPointer;
    private static Frame|null $TF;

    static function init(): void {
        self::$GF = new Frame();
        self::$TF = null;
        self::$LF = array();
        self::$stackPointer = -1;
    }

    static function createFrame(): void {
        self::$TF = new Frame();
    }

    private static function getStackPointer(): int {
        return self::$stackPointer;
    }

    private static function incrementStackPointer(): void {
        self::$stackPointer++;
    }

    private static function decrementStackPointer(): void {
        self::$stackPointer--;
    }
    static function pushFrame(): void {
        if (!self::isTFInitialized()) {
            exit(ReturnCode::FRAME_ACCESS_ERROR);
        }
        self::incrementStackPointer();
        self::$LF[self::getStackPointer()] = self::$TF;
        self::$TF = null;
    }

    static function popFrame(): void {
        if (self::isLFEmpty()) {
            exit(ReturnCode::FRAME_ACCESS_ERROR);
        }
        self::$TF = self::$LF[self::getStackPointer()];
        unset(self::$LF[self::getStackPointer()]);
        self::decrementStackPointer();
    }

    static function findInScope(string $name, string $frame): Variable {
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

    static function isTFInitialized(): bool {
        return self::$TF !== null;
    }

    static function isLFEmpty(): bool {
        return self::getStackPointer() === -1;
    }

    static function getFrame(string $frameName): Frame {
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
