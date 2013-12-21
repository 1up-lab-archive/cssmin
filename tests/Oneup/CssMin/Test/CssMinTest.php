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

    public function testMinifyComplexCss()
    {
        $str = CssMin::minify('
            @charset \'UTF-8\';
            a[href^="dude"]{}
             #id .class9-twoo {
                _background-position: -12.3px;
        	    -moz-color :#fff;
        	    wi\dth: 20.0.px;
        	    height: .2px;
        	    font: 1/2;
        	}
        	a > b {
        	    border: none
        	}
        	/* this is it */
        ');

        $this->assertEquals('@charset \'UTF-8\';a[href^="dude"]{}#id .class9-twoo{_background-position:-12.3px;-moz-color:#fff;wi\dth:20.0.px;height:.2px;font:1/2;}a > b{border:none;}/* this is it */', $str);
    }
}
