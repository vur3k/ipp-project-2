<?php
/**
 * IPP Project II.
 * @brief IPPCode24 language interpreter
 * @package IPP\Student\Frame
 * @file Frame.php
 * @author Vaclav Pribyl <xpriby22@stud.fit.vutbr.cz>
 * @date 14-04-2024
 */
namespace IPP\Student\Frame;

use IPP\Student\Argument\Variable;
use IPP\Student\Exception\SemanticErrorException;
use IPP\Student\Exception\VariableAccessErrorException;

/**
 * Class representing a data frame in the IPPCode24 language
 */
class Frame {
    /** @var Variable[] */
    private array $variables = [];

    public function defVar(Variable $var): void {
        if ($this->isDefined($var->getName())) {
            throw new SemanticErrorException();
        }
        $this->variables[$var->getName()] = $var;
    }

    public function isDefined(string $name): bool {
        return isset($this->variables[$name]);
    }

    public function getVar(string $name): Variable {
        if ($this->isDefined($name)) {
            return $this->variables[$name];
        }
        throw new VariableAccessErrorException();
    }
}
