<?php

namespace Oneup\CssMin\Minifier\Filter;

abstract class aCssMinifierFilter
{
    /**
     * Filter configuration.
     *
     * @var array
     */
    protected $configuration = array();

    /**
     * The CssMinifier of the filter.
     *
     * @var CssMinifier
     */
    protected $minifier = null;

    /**
     * Constructor.
     *
     * @param  CssMinifier $minifier      The CssMinifier object of this plugin.
     * @param  array       $configuration Filter configuration [optional]
     * @return void
     */
    public function __construct(CssMinifier $minifier, array $configuration = array())
    {
        $this->configuration	= $configuration;
        $this->minifier			= $minifier;
    }

    /**
     * Filter the tokens.
     *
     * @param  array   $tokens Array of objects of type aCssToken
     * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
     */
    abstract public function apply(array &$tokens);
}
