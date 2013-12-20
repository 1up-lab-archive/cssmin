<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a @keyframes at-rule block.
 */
class CssAtKeyframesStartToken extends aCssAtBlockStartToken
{
    /**
     * Name of the at-rule.
     *
     * @var string
     */
    public $AtRuleName = "keyframes";

    /**
     * Name
     *
     * @var string
     */
    public $Name = "";

    /**
     * Sets the properties of the @page at-rule.
     *
     * @param  string $selector Selector
     * @return void
     */
    public function __construct($name, $atRuleName = null)
    {
        $this->Name = $name;
        if (!is_null($atRuleName)) {
            $this->AtRuleName = $atRuleName;
        }
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@" . $this->AtRuleName . " \"" . $this->Name . "\"{";
    }
}
