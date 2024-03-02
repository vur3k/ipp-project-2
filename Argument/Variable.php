<?php

namespace IPP\Student\Argument;

use IPP\Core\ReturnCode;
use IPP\Student\Frame\FrameStack;

class Variable extends Argument {
    private string|int|null $data;
    private string|null $dataType;
    private string $frame;
    public function __construct(string $name) {
        $split = explode('@', $name, 2);
        parent::__construct($split[1], 'var');
        $this->frame = trim($split[0]);
        $this->data = null;
        $this->dataType = null;
    }

    public function getName(): string {
        return parent::getValue();
    }

    public function getFrame(): string {
        return $this->frame;
    }

    public function setValue(Argument $data): void {
        $var = FrameStack::findInScope($this->getName(), $this->getFrame());
        if ($data instanceof Variable) {
            $dataVar = FrameStack::findInScope($data->getName(), $data->getFrame());
            $var->assignVal($dataVar->getVarAsConst());
        }
        elseif ($data->isConst()) {
            $var->assignVal($data);
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }

    public function getVarType(): string|null {
        return $this->dataType;
    }

    public function isAssigned(): bool {
        return $this->getVarType() !== null;
    }

    public function getValue(): string|int|bool {
        switch($this->getVarType()) {
            case 'int':
            case 'string':
            case 'nil':
                return $this->data;
            case 'bool':
                return $this->data === 'true';
            default:
                exit(ReturnCode::VALUE_ERROR);
        }
    }

    public function isInt(): bool {
        return $this->getVarType() === 'int';
    }

    public function isBool(): bool {
        return $this->getVarType() === 'bool';
    }

    public function isString(): bool {
        return $this->getVarType() === 'string';
    }

    public function isNil(): bool {
        return $this->getVarType() === 'nil';
    }

    public function isNonNilConst(): bool {
        return false;
    }

    public function isConst(): bool {
        return false;
    }

    public function getVarAsConst(): Argument {
        $var = FrameStack::findInScope($this->getName(), $this->getFrame());
        if ($var->isAssigned()) {
            if ($var->isNil()) {
                return new Argument('', 'nil');
            }
            elseif ($var->isBool()) {
                return new Argument($var->getValue() ? 'true' : 'false', 'bool');
            }
            return new Argument($var->getValue(), $var->getVarType());
        }
        exit(ReturnCode::VALUE_ERROR);
    }

    private function assignVal(Argument $const): void {
        if ($const->isBool()) {
            $this->data = $const->getValue() ? 'true' : 'false';
        }
        else {
            $this->data = $const->getValue();
        }
        $this->dataType = $const->getType();
    }
}