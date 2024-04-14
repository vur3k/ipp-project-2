<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student
 * @file student/Interpreter.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Argument;

use IPP\Student\Exception\OperandTypeErrorException;
use IPP\Student\Exception\ValueErrorException;
use IPP\Student\Frame\FrameStack;

/**
 * Class representing a variable in the IPPCode24 language
 */
class Variable extends Argument {
    private string|int|float|null $data;
    private ?string $dataType;
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
            throw new OperandTypeErrorException();
        }
    }

    public function getVarType(): ?string {
        return $this->dataType;
    }

    public function isAssigned(): bool {
        return $this->getVarType() !== null;
    }

    public function getValue(): string|int|bool|float {
        if ($this->isAssigned()) {
            return $this->isBool() ? $this->data === 'true' : $this->data;
        }
        else {
            throw new ValueErrorException();
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

    public function isFloat(): bool {
        return $this->getVarType() === 'float';
    }

    public function isNum(): bool {
        return $this->isInt() || $this->isFloat();
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
        throw new ValueErrorException();
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
