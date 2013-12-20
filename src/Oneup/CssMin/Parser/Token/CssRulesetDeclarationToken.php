<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents a ruleset declaration.
 */
class CssRulesetDeclarationToken extends aCssDeclarationToken
{
    /**
     * Media types of the declaration.
     *
     * @var array
     */
    public $MediaTypes = array("all");

    /**
     * Set the properties of a ddocument- or at-rule @media level declaration.
     *
     * @param  string  $property    Property of the declaration
     * @param  string  $value       Value of the declaration
     * @param  mixed   $mediaTypes  Media types of the declaration
     * @param  boolean $isImportant Is the !important flag is set
     * @param  boolean $isLast      Is the declaration the last one of the ruleset
     * @return void
     */
    public function __construct($property, $value, $mediaTypes = null, $isImportant = false, $isLast = false)
    {
        parent::__construct($property, $value, $isImportant, $isLast);
        $this->MediaTypes	= $mediaTypes ? $mediaTypes : array("all");
    }
}
