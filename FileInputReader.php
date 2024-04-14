<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student
 * @file FileInputReader.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student;

/**
 * Extended FileInputReader with implemented readFloat method
 */
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
