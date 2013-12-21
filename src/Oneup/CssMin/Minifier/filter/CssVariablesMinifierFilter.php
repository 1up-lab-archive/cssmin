<?php

namespace Oneup\CssMin\Minifier\Filter;

class CssVariablesMinifierFilter extends aCssMinifierFilter
{
    /**
     * Implements {@link aCssMinifierFilter::filter()}.
     *
     * @param  array   $tokens Array of objects of type aCssToken
     * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
     */
    public function apply(array &$tokens)
    {
        $variables			= array();
        $defaultMediaTypes	= array("all");
        $mediaTypes			= array();
        $remove				= array();

        $tokenNamespace = "Oneup\CssMin\Parser\Token\\";

        for ($i = 0, $l = count($tokens); $i < $l; $i++) {
            // @variables at-rule block found
            if (get_class($tokens[$i]) === $tokenNamespace . "CssAtVariablesStartToken") {
                $remove[] = $i;
                $mediaTypes = (count($tokens[$i]->MediaTypes) == 0 ? $defaultMediaTypes : $tokens[$i]->MediaTypes);
                foreach ($mediaTypes as $mediaType) {
                    if (!isset($variables[$mediaType])) {
                        $variables[$mediaType] = array();
                    }
                }
                // Read the variable declaration tokens
                for ($i = $i; $i < $l; $i++) {
                    // Found a variable declaration => read the variable values
                    if (get_class($tokens[$i]) === $tokenNamespace . "CssAtVariablesDeclarationToken") {
                        foreach ($mediaTypes as $mediaType) {
                            $variables[$mediaType][$tokens[$i]->Property] = $tokens[$i]->Value;
                        }
                        $remove[] = $i;
                    }
                    // Found the variables end token => break;
                    elseif (get_class($tokens[$i]) === $tokenNamespace . "CssAtVariablesEndToken") {
                        $remove[] = $i;
                        break;
                    }
                }
            }
        }

        // Variables in @variables at-rule blocks
        foreach ($variables as $mediaType => $null) {
            foreach ($variables[$mediaType] as $variable => $value) {
                // If a var() statement in a variable value found...
                if (stripos($value, "var") !== false && preg_match_all("/var\((.+)\)/iSU", $value, $m)) {
                    // ... then replace the var() statement with the variable values.
                    for ($i = 0, $l = count($m[0]); $i < $l; $i++) {
                        $variables[$mediaType][$variable] = str_replace($m[0][$i], (isset($variables[$mediaType][$m[1][$i]]) ? $variables[$mediaType][$m[1][$i]] : ""), $variables[$mediaType][$variable]);
                    }
                }
            }
        }

        // Remove the complete @variables at-rule block
        foreach ($remove as $i) {
            $tokens[$i] = null;
        }

        if (!($plugin = $this->minifier->getPlugin("Oneup\CssMin\Minifier\Plugin\CssVariablesMinifierPlugin"))) {
            var_dump($plugin); die();
            throw new \InvalidArgumentException(sprintf('The plugin CssVariablesMinifierPlugin was not found but is required for %s', __CLASS__));
        } else {
            $plugin->setVariables($variables);
        }

        return count($remove);
    }
}
