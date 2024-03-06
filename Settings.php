<?php

namespace IPP\Student;

class Settings extends \IPP\Core\Settings {
    public function getInputReader(): FileInputReader {
        static $reader = new FileInputReader($this->input);
        return $reader;
    }

    public function getStdOutWriter(): StreamWriter {
        static $writer = new StreamWriter(STDOUT);
        return $writer;
    }

    public function getStdErrWriter(): StreamWriter {
        static $writer = new StreamWriter(STDERR);
        return $writer;
    }
}
