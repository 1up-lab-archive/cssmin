<?php

namespace Oneup\CssMin\Minifier\Filter;

class CssRemoveCommentsMinifierFilter extends aCssMinifierFilter
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
            if (get_class($tokens[$i]) === "CssCommentToken") {
                $tokens[$i] = null;
                $r++;
            }
        }

        return $r;
    }
}
