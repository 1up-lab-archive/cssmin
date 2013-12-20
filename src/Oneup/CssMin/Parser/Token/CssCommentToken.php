<?php

namespace Oneup\CssMin\Parser\Token;

/**
 * This {@link aCssToken CSS token} represents a CSS comment.
 */
class CssCommentToken extends aCssToken
{
    /**
     * Comment as Text.
     *
     * @var string
     */
    public $Comment = "";

    /**
     * Set the properties of a comment token.
     *
     * @param  string $comment Comment including comment delimiters
     * @return void
     */
    public function __construct($comment)
    {
        $this->Comment = $comment;
    }

    /**
     * Implements {@link aCssToken::__toString()}.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->Comment;
    }
}
