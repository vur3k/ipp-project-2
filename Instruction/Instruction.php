<?php
namespace IPP\Student\Instruction;

use IPP\Core\ReturnCode;
use IPP\Student\Argument;
use IPP\Student\Variable;

class Instruction {
    private int $order;
    private int $argCnt;
    /**
     * @var Argument[]
     */
    private array $args;

    protected function __construct(\DOMElement $instruction, int $argCnt) {
        if ($instruction->nodeName !== 'instruction') {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        $this->setOrder((int)$instruction->getAttribute('order'));

        if ($argCnt !== $instruction->childElementCount) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        $this->setArgCnt($argCnt);
        $this->storeArgs($instruction);
    }

    public function execute(): void {}

    private function setOrder(int $order): void {
        if ($order < 1) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
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
        exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
    }

    private function setArg(Argument $arg, int $n): void {
        if ($n > $this->getArgCnt() || isset($this->args[$n])) {
            exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
        }
        $this->args[$n] = $arg;
    }

    private function storeArgs(\DOMElement $instruction): void {
        $child = $instruction->firstElementChild;
        for ($i = 0; $i < $this->getArgCnt(); $i++) {
            $tag = trim($child->nodeValue);
            $split = explode('@', $tag, 2);
            if ($split[0] === 'GF' || $split[0] === 'LF' || $split[0] === 'TF') {
                $arg = new Variable($tag);
            }
            else {
                $type = $child->getAttribute('type');
                if ($type === 'string') {
                    $arg = new Argument(Argument::expandString($tag), $type);
                }
                else {
                    $arg = new Argument($tag, $child->getAttribute('type'));
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
                    $this->setArg($arg,3);
                    break;
                default:
                    exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
            }
            $child = $child->nextElementSibling;
        }
    }
}