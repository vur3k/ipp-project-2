<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student
 * @file Settings.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student;

use IPP\Core\Interface\InputReader;
use IPP\Core\Interface\OutputWriter;

/**
 * Altered settings class to initialise custom input and output readers
 */
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
