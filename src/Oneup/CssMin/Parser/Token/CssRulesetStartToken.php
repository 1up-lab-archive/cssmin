<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a ruleset.
 */
class CssRulesetStartToken extends aCssRulesetStartToken
{
    /**
     * Array of selectors.
     *
     * @var array
     */
    public $Selectors = array();

    /**
     * Set the properties of a ruleset token.
     *
     * @param  array $selectors Selectors of the ruleset
     * @return void
     */
    public function __construct(array $selectors = array())
    {
        $this->Selectors = $selectors;
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return implode(",", $this->Selectors) . "{";
    }
}
