<?php

/**
 * Smarty compiler exception class
 *
 * @package Smarty
 */
class SmartyCompilerException extends SmartyException
{
    /**
     * @return string
     */
    public function __toString()
    {
        return ' --> Smarty Compiler: ' . $this->message . ' <-- ';
    }

    /**
     * Magic setter to handle protected $line property from Exception
     * PHP 8 made Exception::$line protected, but Smarty tries to set it publicly
     */
    public function __set($name, $value)
    {
        if ($name === 'line') {
            // Use reflection to set the protected property
            $reflection = new ReflectionProperty('Exception', 'line');
            $reflection->setAccessible(true);
            $reflection->setValue($this, (int)$value);
        }
    }

    /**
     * The template source snippet relating to the error
     *
     * @type string|null
     */
    public $source = null;

    /**
     * The raw text of the error message
     *
     * @type string|null
     */
    public $desc = null;

    /**
     * The resource identifier or template name
     *
     * @type string|null
     */
    public $template = null;
}
