<?php
/**
 * This {@link aCssToken CSS token} represents a ruleset declaration.
 *
 * @package		CssMin/Tokens
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssRulesetDeclarationToken extends aCssToken
	{
	/**
	 * Property name of the declaration.
	 * 
	 * @var string
	 */
	public $Property = "";
	/**
	 * Is the declaration flagged as important?
	 * 
	 * @var boolean
	 */
	public $IsImportant = false;
	/**
	 * Is the declaration flagged as last one of the ruleset?
	 * 
	 * @var boolean
	 */
	public $IsLast = false;
	/**
	 * Media types of the declaration.
	 * 
	 * @var array
	 */
	public $MediaTypes = array("all");
	/**
	 * Value of the declaration.
	 * 
	 * @var string
	 */
	public $Value = "";
	/**
	 * Set the properties of a ddocument- or at-rule @media level declaration. 
	 * 
	 * @param string $property Property of the declaration
	 * @param string $value Value of the declaration
	 * @param mixed $mediaTypes Media types of the declaration
	 * @param boolean $isImportant Is the !important flag is set
	 * @param boolean $isLast Is the declaration the last one of the ruleset
	 * @return void
	 */
	public function __construct($property, $value, $mediaTypes = null, $isImportant = false, $isLast = false)
		{
		$this->Property		= $property;
		$this->Value		= $value;
		$this->MediaTypes	= $mediaTypes ? $mediaTypes : array("all");
		$this->IsImportant	= $isImportant;
		$this->IsLast		= $isLast;
		}
	/**
	 * Implements {@link aCssToken::__toString()}.
	 * 
	 * @return string
	 */
	public function __toString()
		{
		return $this->Property . ":" . $this->Value . ($this->IsImportant ? " !important" : "") . ($this->IsLast ? "" : ";");
		}
	}
?>