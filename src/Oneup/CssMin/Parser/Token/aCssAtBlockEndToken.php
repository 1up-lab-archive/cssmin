<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * Abstract definition of a for at-rule block end token.
 */
abstract class aCssAtBlockEndToken extends aCssToken
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
