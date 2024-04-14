<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Instruction
 * @file student/Instruction/AbstractInstruction.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Instruction;

use IPP\Student\Argument\Argument;
use IPP\Student\Argument\Variable;
use IPP\Student\Exception\InvalidSourceStructureException;

/**
 * Base abstract class representing an instruction in the IPPCode24 language
 */
abstract class AbstractInstruction {
    private int $order;
    private int $argCnt;
    /** @var Argument[] */
    private array $args;

    protected function __construct(\DOMElement $instruction, int $argCnt) {
        if ($instruction->nodeName !== 'instruction') {
            throw new InvalidSourceStructureException();
        }
        $order = $instruction->getAttribute('order');
        if ($order === "") {
            throw new InvalidSourceStructureException();
        }
        $this->setOrder((int)$order);

        if ($argCnt !== $instruction->childElementCount) {
            throw new InvalidSourceStructureException();
        }
        $this->setArgCnt($argCnt);
        $this->storeArgs($instruction);
    }

    abstract public function execute(): void;

    private function setOrder(int $order): void {
        if ($order < 1) {
            throw new InvalidSourceStructureException();
        }
        $this->order = $order;
    }

    private function setArgCnt(int $argCnt): void {
        $this->argCnt = $argCnt;
    }

    public function getOrder(): int {
        return $this->order;
    }

    public function getArgCnt(): int {
        return $this->argCnt;
    }

    public function getArg(int $n): Argument {
        if ($this->getArgCnt() >= $n && isset($this->args[$n])) {
            return $this->args[$n];
        }
        throw new InvalidSourceStructureException();
    }

    private function setArg(Argument $arg, int $n): void {
        if ($n > $this->getArgCnt() || isset($this->args[$n])) {
            throw new InvalidSourceStructureException();
        }
        $this->args[$n] = $arg;
    }

    private function storeArgs(\DOMElement $instruction): void {
        $child = $instruction->firstElementChild;
        for ($i = 0; $i < $this->getArgCnt(); $i++) {
            $tag = trim($child->nodeValue);
            $type = $child->getAttribute('type');
            if ($type === "") {
                throw new InvalidSourceStructureException();
            }
            elseif ($type === 'var') {
                $split = explode('@', $tag, 2);
                if ($split[0] === 'GF' || $split[0] === 'LF' || $split[0] === 'TF') {
                    $arg = new Variable($tag);
                }
                else {
                    throw new InvalidSourceStructureException();
                }
            }
            else {

                if ($type === 'string') {
                    $arg = new Argument(Argument::expandString($tag), 'string');
                }
                else {
                    $arg = new Argument($tag, $type);
                }
            }
            switch ($child->nodeName) {
                case 'arg1':
                    $this->setArg($arg, 1);
                    break;
                case 'arg2':
                    $this->setArg($arg, 2);
                    break;
                case 'arg3':
                    $this->setArg($arg, 3);
                    break;
                default:
                    throw new InvalidSourceStructureException();
            }
            $child = $child->nextElementSibling;
        }
    }
}
