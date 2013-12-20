<?php

namespace Oneup\CssMin\Minifier\Filter;

class CssRemoveLastDelarationSemiColonMinifierFilter extends aCssMinifierFilter
{
    /**
     * Implements {@link aCssMinifierFilter::filter()}.
     *
     * @param  array   $tokens Array of objects of type aCssToken
     * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
     */
    public function apply(array &$tokens)
    {
        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            $current	= get_class($tokens[$i]);
            $next		= isset($tokens[$i+1]) ? get_class($tokens[$i+1]) : false;
            if (($current === "CssRulesetDeclarationToken" && $next === "CssRulesetEndToken") ||
                ($current === "CssAtFontFaceDeclarationToken" && $next === "CssAtFontFaceEndToken") ||
                ($current === "CssAtPageDeclarationToken" && $next === "CssAtPageEndToken"))
            {
                $tokens[$i]->IsLast = true;
            }
        }

        return 0;
    }
}
