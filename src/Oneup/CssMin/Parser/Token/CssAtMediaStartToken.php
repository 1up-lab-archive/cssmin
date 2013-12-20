<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a @media at-rule block.
 */
class CssAtMediaStartToken extends aCssAtBlockStartToken
{
    /**
     * Sets the properties of the @media at-rule.
     *
     * @param  array $mediaTypes Media types
     * @return void
     */
    public function __construct(array $mediaTypes = array())
    {
        $this->MediaTypes = $mediaTypes;
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@media " . implode(",", $this->MediaTypes) . "{";
    }
}
