<?php
/**
 * CSS Error.
 * 
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0.b1
 */
class CssError
	{
	/**
	 * Error message.
	 * 
	 * @var string
	 */
	public $Message = "";
	/**
	 * Source.
	 * 
	 * @var string
	 */
	public $Source = "";
	/**
	 * Constructor triggering the error.
	 * 
	 * @param string $message Error message
	 * @param string $source Corresponding line [optional]
	 * @return void
	 */
	public function __construct($message, $source = "")
		{
		$this->Message	= $message;
		$this->Source	= $source;
		}
	/**
	 * Returns the error as formatted string.
	 * 
	 * @return string
	 */	
	public function __toString()
		{
		return $this->Message . ($this->Source ? ":<p><code>" . $this->Source . "</code></p>": "");
		}
	}
?>