<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents a declaration of a @variables at-rule block.
 */
class CssAtVariablesDeclarationToken extends aCssDeclarationToken
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
