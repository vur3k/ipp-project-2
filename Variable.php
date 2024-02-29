<?php

namespace IPP\Student;

use IPP\Core\ReturnCode;
use IPP\Student\Frame\FrameStack;

class Variable extends Argument
{
    private string|null $data;
    private string|null $dataType;
    private string $originFrame;
    public function __construct(string $name)
    {
        $split = explode('@', $name, 2);
        parent::__construct($split[1], 'var');
        $this->originFrame = trim($split[0]);
        $this->data = null;
        $this->dataType = null;
    }

    public function getName(): string
    {
        return parent::getValue();
    }

    public function getOriginFrame(): string
    {
        return $this->originFrame;
    }

    public function setValue(Argument $data): void
    {
        $var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        if ($data instanceof Variable) {
            $dataVar = FrameStack::findInScope($data->getName(), $data->getOriginFrame());
            $var->assignVal($dataVar->getVarAsConst());
        }
        elseif ($data->isConst()) {
            $var->assignVal($data);
        }
        else {
            exit(ReturnCode::OPERAND_TYPE_ERROR);
        }
    }

    public function getVarType(): string|null
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->dataType;
    }

    public function isAssigned(): bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->getVarType() !== null;
    }

    public function getValue(): string|int|bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        switch($this->getVarType()){
            case 'int':
                return (int)$this->data;
            case 'string':
                return $this->data;
            case 'bool':
                if ($this->data === 'true') {
                    return true;
                }
                return false;
            default:
                exit(ReturnCode::VALUE_ERROR);
        }
    }

    public function isInt(): bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->getVarType() === 'int';
    }

    public function isBool(): bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->getVarType() === 'bool';
    }

    public function isString(): bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->getVarType() === 'string';
    }

    public function isNil(): bool
    {
        #$var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        return $this->getVarType() === 'nil';
    }

    public function isConst(): bool
    {
        return false;
    }

    public function getVarAsConst(): Argument
    {
        $var = FrameStack::findInScope($this->getName(), $this->getOriginFrame());
        if ($var->isAssigned()) {
            if ($var->isNil()) {
                return new Argument('nil', 'nil');
            }
            elseif ($var->isBool()) {
                if ($var->getValue()) {
                    return new Argument('true', 'bool');
                }
                return new Argument('false', 'bool');
            }
            return new Argument($var->getValue(), $var->getVarType());
        }
        exit(ReturnCode::VALUE_ERROR);
    }

    private function assignVal(Argument $const): void {
        if ($const->isBool()) {
            if ($const->getValue()) {
                $this->data = 'true';
            }
            else {
                $this->data = 'false';
            }
        }
        else {
            $this->data = $const->getValue();
        }
        $this->dataType = $const->getType();
    }
}