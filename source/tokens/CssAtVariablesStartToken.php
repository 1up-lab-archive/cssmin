<?php
/**
 * This {@link aCssToken CSS token} represents the start of a @variables at-rule block.
 *
 * @package		CssMin/Tokens
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssAtVariablesStartToken extends aCssNullToken
	{
	/**
	 * Media types of the @variables at-rule block.
	 * 
	 * @var array
	 */
	public $MediaTypes = array();
	/**
	 * Set the properties of a @variables at-rule token.
	 * 
	 * @param array $mediaTypes Media types
	 * @return void
	 */
	public function __construct($mediaTypes = null)
		{
		$this->MediaTypes = $mediaTypes ? $mediaTypes : array("all");
		}
	}
?>