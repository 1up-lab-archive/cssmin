<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents the start of a @font-face at-rule block.
 */
class CssAtFontFaceStartToken extends aCssAtBlockStartToken
{
    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@font-face{";
    }
}
