<?php

namespace Oneup\CssMin\Minifier\Filter;

class CssRemoveEmptyAtBlocksMinifierFilter extends aCssMinifierFilter
{
    /**
     * Implements {@link aCssMinifierFilter::filter()}.
     *
     * @param  array   $tokens Array of objects of type aCssToken
     * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
     */
    public function apply(array &$tokens)
    {
        $r = 0;
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            $current	= get_class($tokens[$i]);
            $next		= isset($tokens[$i + 1]) ? get_class($tokens[$i + 1]) : false;
            if (($current === "CssAtFontFaceStartToken" && $next === "CssAtFontFaceEndToken") ||
                ($current === "CssAtKeyframesStartToken" && $next === "CssAtKeyframesEndToken") ||
                ($current === "CssAtPageStartToken" && $next === "CssAtPageEndToken") ||
                ($current === "CssAtMediaStartToken" && $next === "CssAtMediaEndToken"))
            {
                $tokens[$i]		= null;
                $tokens[$i + 1]	= null;
                $i++;
                $r = $r + 2;
            }
        }

        return $r;
    }
}
