<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Frame
 * @file student/Frame/FrameStack.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Frame;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\FrameAccessErrorException;
use IPP\Student\Exception\InvalidSourceStructureException;
use IPP\Student\Exception\VariableAccessErrorException;

/**
 * Class implementing a static frame stack of the IPPCode24 language frames
 */
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
            throw new FrameAccessErrorException();
        }
        self::incrementStackPointer();
        self::$LF[self::getStackPointer()] = self::$TF;
        self::$TF = null;
    }

    static public function popFrame(): void {
        if (self::isLFEmpty()) {
            throw new FrameAccessErrorException();
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
                    throw new FrameAccessErrorException();
                }
                if (self::$LF[self::getStackPointer()]->isDefined($name)) {
                    $var = self::$LF[self::getStackPointer()]->getVar($name);
                    break;
                }
                break;
            case 'TF':
                if (!self::isTFInitialized()) {
                    throw new FrameAccessErrorException();
                }
                $var = self::$TF->getVar($name);
                break;
            default:
                throw new InvalidSourceStructureException();
        }
        if ($var === null) {
            throw new VariableAccessErrorException();
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
                    throw new FrameAccessErrorException();
                }
                return self::$LF[self::getStackPointer()];
            case 'TF':
                if (!self::isTFInitialized()) {
                    throw new FrameAccessErrorException();
                }
                return self::$TF;
            default:
                throw new InvalidSourceStructureException();
        }
    }
}
