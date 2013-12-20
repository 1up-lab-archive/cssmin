<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * Abstract definition of a for ruleset end token.
 */
abstract class aCssRulesetEndToken extends aCssToken
{
    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "}";
    }
}
