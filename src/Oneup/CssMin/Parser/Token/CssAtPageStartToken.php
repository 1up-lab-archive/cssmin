<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a @page at-rule block.
 */
class CssAtPageStartToken extends aCssAtBlockStartToken
{
    /**
     * Selector.
     *
     * @var string
     */
    public $Selector = "";

    /**
     * Sets the properties of the @page at-rule.
     *
     * @param  string $selector Selector
     * @return void
     */
    public function __construct($selector = "")
    {
        $this->Selector = $selector;
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@page" . ($this->Selector ? " " . $this->Selector : "") . "{";
    }
}
