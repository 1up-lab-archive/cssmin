<?php

namespace Oneup\CssMin\Parser\Plugin;

/**
 * {@link aCssParserPlugin Parser plugin} for parsing comments.
 *
 * Adds a {@link CssCommentToken} to the parser if a comment was found.
 */
class CssCommentParserPlugin extends aCssParserPlugin
{
    /**
     * Stored buffer for restore.
     *
     * @var string
     */
    private $restoreBuffer = "";

    /**
     * Implements {@link aCssParserPlugin::getTriggerChars()}.
     *
     * @return array
     */
    public function getTriggerChars()
    {
        return array("*", "/");
    }

    /**
     * Implements {@link aCssParserPlugin::getTriggerStates()}.
     *
     * @return array
     */
    public function getTriggerStates()
    {
        return false;
    }

    /**
     * Implements {@link aCssParserPlugin::parse()}.
     *
     * @param  integer $index        Current index
     * @param  string  $char         Current char
     * @param  string  $previousChar Previous char
     * @return mixed   TRUE will break the processing; FALSE continue with the next plugin; integer set a new index and break the processing
     */
    public function parse($index, $char, $previousChar, $state)
    {
        if ($char === "*" && $previousChar === "/" && $state !== "T_COMMENT") {
            $this->parser->pushState("T_COMMENT");
            $this->parser->setExclusive(__CLASS__);
            $this->restoreBuffer = substr($this->parser->getAndClearBuffer(), 0, -2);
        } elseif ($char === "/" && $previousChar === "*" && $state === "T_COMMENT") {
            $this->parser->popState();
            $this->parser->unsetExclusive();
            $this->parser->appendToken(new CssCommentToken("/*" . $this->parser->getAndClearBuffer()));
            $this->parser->setBuffer($this->restoreBuffer);
        } else {
            return false;
        }

        return true;
    }
}
