<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * Abstract definition of a ruleset declaration token.
 */
abstract class aCssDeclarationToken extends aCssToken
{
    /**
     * Is the declaration flagged as important?
     *
     * @var boolean
     */
    public $IsImportant = false;

    /**
     * Is the declaration flagged as last one of the ruleset?
     *
     * @var boolean
     */
    public $IsLast = false;

    /**
     * Property name of the declaration.
     *
     * @var string
     */
    public $Property = "";

    /**
     * Value of the declaration.
     *
     * @var string
     */
    public $Value = "";

    /**
     * Set the properties of the @font-face declaration.
     *
     * @param  string  $property    Property of the declaration
     * @param  string  $value       Value of the declaration
     * @param  boolean $isImportant Is the !important flag is set?
     * @param  boolean $IsLast      Is the declaration the last one of the block?
     * @return void
     */
    public function __construct($property, $value, $isImportant = false, $isLast = false)
    {
        $this->Property		= $property;
        $this->Value		= $value;
        $this->IsImportant	= $isImportant;
        $this->IsLast		= $isLast;
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->Property . ":" . $this->Value . ($this->IsImportant ? " !important" : "") . ($this->IsLast ? "" : ";");
    }
}
