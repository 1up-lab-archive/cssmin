<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * Abstract definition of a CSS token class.
 *
 * Every token has to extend this class.
 */
abstract class aCssToken
{
    /**
     * Returns the token as string.
     *
     * @return string
     */
    abstract public function __toString();
}
