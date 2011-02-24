<?php
/**
 * CssMin - A (simple) css minifier with benefits
 * 
 * --
 * Copyright (c) 2011 Joe Scylla <joe.scylla@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * --
 * 
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssMin
	{
	/**
	 * Index of classes
	 * 
	 * @var array
	 */
	private static $classIndex = array();
	/**
	 * Create a build version of CssMin.
	 * 
	 * The php source get minifed by using the php function {@link http://goo.gl/eIcoH php_strip_whitespace()}.
	 * 
	 * @param string $target Path including file name were the build version should be saved [optional]
	 * @return string Minifed build version
	 */
	public static function build($target = "")
		{
		$files		= array();
		$source		= "";
		$comment	= "";
		// Get all source files
		$paths = array(dirname(__FILE__));
		while (list($i, $path) = each($paths))
			{
			foreach (glob($path . "*", GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT) as $subDirectory)
				{
				$paths[] = $subDirectory;
				}
			foreach (glob($path . "*.php", 0) as $file)
				{
				$files[basename($file)] = $file;
				}
			}
		krsort($files);
		// Read the content of the source files and extract the main comment block
		foreach ($files as $file)
			{
			if (basename($file) == "CssMin.php")
				{
				$comment = file_get_contents($file);;
				preg_match("/\/\*.+\*\//sU", $comment, $m);
				$comment = $m[0];
				}
			$source .= file_get_contents($file);
			}
		// Remove php delimiters
		$source	= str_replace(array("<?php", "?>"), "", $source);
		// Add php delimiters and the main comment and save the file
		$source = "<?php\n" . $comment . $source . "?>";
		if ($target && file_put_contents($target, $source) === false)
			{
			return false;
			}
		return $source;
		}
	/**
	 * @link http://goo.gl/JrW54 Autoload} function of CssMin.
	 * 
	 * @param string $class Name of the class
	 * @return void
	 */
	public static function autoload($class)
		{
		if (isset(self::$classIndex[$class]))
			{
			require(self::$classIndex[$class]);
			}
		}
	/**
	 * Initialises CssMin.
	 * 
	 * @return void
	 */
	public static function initialise()
		{
		// Create the class index for autoloading or including
		$paths = array(dirname(__FILE__));
		while (list($i, $path) = each($paths))
			{
			foreach (glob($path . "*", GLOB_MARK | GLOB_ONLYDIR | GLOB_NOSORT) as $subDirectory)
				{
				$paths[] = $subDirectory;
				}
			foreach (glob($path . "*.php", 0) as $file)
				{
				$class = substr(basename($file), 0, -4);
				self::$classIndex[$class] = $file;
				}
			}
		krsort(self::$classIndex);
		// Only use autoloading if spl_autoload_register() is available and no __autoload() is defined (because 
		// __autoload() breaks if spl_autoload_register() is used. 
		if (function_exists("spl_autoload_register") && !is_callable("__autoload"))
			{
			spl_autoload_register(array(__CLASS__, "autoload"));
			}
		// Otherwise include all class files
		else
			{
			foreach (self::$classIndex as $class => $file)
				{
				if (!class_exists($class))
					{
					require_once($file);
					}
				}
			}
		}
	/**
	 * Minifies CSS source.
	 * 
	 * @param string $source CSS source
	 * @param array $filters Filter configuration [optional]
	 * @param array $plugins Plugin configuration [optional]
	 * @return string Minified CSS
	 */
	public static function minify($source, array $filters = null, array $plugins = null)
		{
		$minifier = new CssMinifier($source, $filters, $plugins);
		return $minifier->getMinified();
		}
	/**
	 * Parse the CSS source.
	 * 
	 * @param string $source CSS source
	 * @param array $plugins Plugin configuration [optional]
	 * @return array Array of aCssToken
	 */
	public static function parse($source, array $plugins = null)
		{
		$parser = new CssParser($source, $plugins);
		return $parser->getTokens();
		}
	}
// Initialises CssMin
CssMin::initialise();
?>