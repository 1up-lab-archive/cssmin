<?php

namespace Oneup\CssMin\Formatter;

abstract class aCssFormatter
{
    /**
     * Indent string.
     *
     * @var string
     */
    protected $indent = "    ";

    /**
     * Declaration padding.
     *
     * @var integer
     */
    protected $padding = 0;

    /**
     * Tokens.
     *
     * @var array
     */
    protected $tokens = array();

    /**
     * Constructor.
     *
     * @param array   $tokens  Array of CssToken
     * @param string  $indent  Indent string [optional]
     * @param integer $padding Declaration value padding [optional]
     */
    public function __construct(array $tokens, $indent = null, $padding = null)
    {
        $this->tokens	= $tokens;
        $this->indent	= !is_null($indent) ? $indent : $this->indent;
        $this->padding	= !is_null($padding) ? $padding : $this->padding;
    }

    /**
     * Returns the array of aCssToken as formatted string.
     *
     * @return string
     */
    abstract public function __toString();
}
