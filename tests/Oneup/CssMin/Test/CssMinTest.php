<?php

namespace Oneup\CssMin\Test;

use Oneup\CssMin\CssMin;

class CssMinTest extends \PHPUnit_Framework_TestCase
{
    public function testMinifySimpleCss()
    {
        $str = CssMin::minify('
            * {
                margin:0;
                padding:0;
            }
        ');

        $this->assertEquals('*{margin:0;padding:0;}', $str);
    }
}
