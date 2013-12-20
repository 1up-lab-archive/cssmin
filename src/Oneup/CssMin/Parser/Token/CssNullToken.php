<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} is a utility token that extends {@link aNullToken} and returns only a empty string.
 */
class CssNullToken extends aCssToken
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
