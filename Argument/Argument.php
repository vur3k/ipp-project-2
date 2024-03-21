<?php

namespace IPP\Student\Argument;
use IPP\Core\ReturnCode;
use IPP\Student\Exception\InvalidSourceStructureException;

class Argument {
    private string|int|float $value;
    private string $type;

    public function __construct(string|int|float $value, string $type) {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getValue(): string|bool|int|float {
        switch ($this->getType()) {
            case 'int':
                return (int)$this->value;
            case 'nil':
                return '';
            case 'bool':
                return $this->value === 'true';
            case 'float':
                return (float)$this->value;
            default:
                return $this->value;
        }
    }

    public function isLabel(): bool {
        return $this->getType() === 'label';
    }

    public function isType(): bool {
        return $this->getType() === 'type';
    }

    public function isInt(): bool {
        return $this->getType() === 'int';
    }

    public function isBool(): bool {
        return $this->getType() === 'bool';
    }

    public function isString(): bool {
        return $this->getType() === 'string';
    }

    public function isNil(): bool {
        return $this->getType() === 'nil';
    }

    public function isFloat(): bool {
        return $this->getType() === 'float';
    }

    public function isNum(): bool {
        return $this->isInt() || $this->isFloat();
    }

    public function isConst(): bool {
        return $this->isNonNilConst() || $this->isNil();
    }

    public function isNonNilConst(): bool {
        return $this->isInt() || $this->isString() || $this->isBool() || $this->isFloat();
    }

    static public function expandString(string $str): string {
        $split = explode('\\', $str);
        $out = $split[0];
        for ($i = 1; $i < count($split); $i++) {
            if (strlen($split[$i]) < 3) {
                throw new InvalidSourceStructureException();
            }
            for ($j = 0; $j < 3; $j++) {
                if ('0' > $split[$i][$j] || $split[$i][$j] > '9') {
                    throw new InvalidSourceStructureException();
                }
            }
            $char = mb_chr((int)($split[$i][0] . $split[$i][1] . $split[$i][2]), 'UTF-8');
            if (!$char) {
                throw new InvalidSourceStructureException();
            }
            $out .= $char;
            $out .= substr($split[$i], 3);
        }
        return $out;
    }
}
