<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents a @import at-rule.
 */
class CssAtImportToken extends aCssToken
{
    /**
     * Import path of the @import at-rule.
     *
     * @var string
     */
    public $Import = "";

    /**
     * Media types of the @import at-rule.
     *
     * @var array
     */
    public $MediaTypes = array();

    /**
     * Set the properties of a @import at-rule token.
     *
     * @param  string $import     Import path
     * @param  array  $mediaTypes Media types
     * @return void
     */
    public function __construct($import, $mediaTypes)
    {
        $this->Import		= $import;
        $this->MediaTypes	= $mediaTypes ? $mediaTypes : array();
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@import \"" . $this->Import . "\"" . (count($this->MediaTypes) > 0 ? " "  . implode(",", $this->MediaTypes) : ""). ";";
    }
}
