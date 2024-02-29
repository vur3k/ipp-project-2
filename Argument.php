<?php

namespace IPP\Student;
use IPP\Core\ReturnCode;

class Argument {
    private string|bool|int $value;
    private string $type;

    public function __construct(string|bool|int $value, string $type) {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType(): string {
        return $this->type;
    }

    public function getValue(): string|bool|int {
        switch ($this->getType()) {
            case 'int':
                return (int)$this->value;
            case 'nil':
                return '';
            case 'bool':
                return $this->value === 'true' || $this->value === true;
            default:
                return $this->value;

        }
    }

    public function isLabel(): bool {
        return $this->type === 'label';
    }

    public function isType(): bool {
        return $this->type === 'type';
    }

    public function isVar(): bool {
        return $this->type === 'var';
    }

    public function isInt(): bool {
        return $this->type === 'int';
    }

    public function isBool(): bool {
        return $this->type === 'bool';
    }

    public function isString(): bool {
        return $this->type === 'string';
    }

    public function isNil(): bool {
        return $this->type === 'nil';
    }

    public function isConst(): bool {
        return $this->isNonNilConst() || $this->isNil();
    }

    public function isNonNilConst(): bool {
        return $this->isInt() || $this->isString() || $this->isBool();
    }

    static function expandString(string $str): string {
        $split = explode('\\', $str);
        $out = $split[0];
        for ($i = 1; $i < count($split); $i++) {
            if (strlen($split[$i]) < 3) {
                exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
            }
            for ($j = 0; $j < 3; $j++) {
                if ('0' > $split[$i][$j] || $split[$i][$j] > '9') {
                    exit(ReturnCode::INVALID_SOURCE_STRUCTURE);
                }
            }
            $char = mb_chr((int)($split[$i][0] . $split[$i][1] . $split[$i][2]), 'UTF-8');
            $out .= $char;
            $out .= substr($split[$i], 3);
        }
        return $out;
    }
}