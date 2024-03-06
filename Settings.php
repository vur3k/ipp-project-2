<?php

namespace IPP\Student;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;

class Settings extends \IPP\Core\Settings {
    public function getInputReader(): InputReader {
        static $reader = new FileInputReader($this->input);
        return $reader;
    }

    public function getStdOutWriter(): OutputWriter {
        static $writer = new StreamWriter(STDOUT);
        return $writer;
    }

    public function getStdErrWriter(): OutputWriter {
        static $writer = new StreamWriter(STDERR);
        return $writer;
    }
}
