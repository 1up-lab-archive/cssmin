<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a @variables at-rule block.
 */
class CssAtVariablesStartToken extends aCssAtBlockStartToken
{
    /**
     * Media types of the @variables at-rule block.
     *
     * @var array
     */
    public $MediaTypes = array();

    /**
     * Set the properties of a @variables at-rule token.
     *
     * @param  array $mediaTypes Media types
     * @return void
     */
    public function __construct($mediaTypes = null)
    {
        $this->MediaTypes = $mediaTypes ? $mediaTypes : array("all");
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "";
    }
}
