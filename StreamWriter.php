<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student
 * @file student/StreamWriter.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student;

/**
 * Extended StreamWriter with implemented writeFloat method
 */
class StreamWriter extends \IPP\Core\StreamWriter {
    public function writeFloat(float $value): void {
        $result = fwrite($this->stream, strval($value));
        $this->checkResult($result);
    }
}
