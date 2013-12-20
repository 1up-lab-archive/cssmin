<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents a @charset at-rule.
 */
class CssAtCharsetToken extends aCssToken
{
    /**
     * Charset of the @charset at-rule.
     *
     * @var string
     */
    public $Charset = "";
    /**
     * Set the properties of @charset at-rule token.
     *
     * @param  string $charset Charset of the @charset at-rule token
     * @return void
     */
    public function __construct($charset)
    {
        $this->Charset = $charset;
    }
    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return "@charset " . $this->Charset . ";";
    }
}
