<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the end of a @variables at-rule block.
 */
class CssAtVariablesEndToken extends aCssAtBlockEndToken
{
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
