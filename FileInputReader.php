<?php

namespace IPP\Student;

class FileInputReader extends \IPP\Core\FileInputReader {
    public function readFloat(): ?float {
        $result = $this->readString();
        if (is_null($result)) return null;
        return filter_var(
            $result,
            FILTER_VALIDATE_FLOAT,
            FILTER_NULL_ON_FAILURE | FILTER_FLAG_ALLOW_SCIENTIFIC | FILTER_FLAG_ALLOW_FRACTION
        );
    }
}
