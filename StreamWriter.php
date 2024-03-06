<?php

namespace IPP\Student;

class StreamWriter extends \IPP\Core\StreamWriter {
    public function writeFloat(float $value): void {
        $result = fwrite($this->stream, strval($value));
        $this->checkResult($result);
    }
}
