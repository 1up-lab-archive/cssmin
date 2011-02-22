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
 * @version		3.0.0.b1
 */
class CssMin
	{
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
		// Remove the initialisation call and php delimiters
		$source	= str_replace("CssMin::initialise();\n", "", $source);
		$source	= str_replace(array("<?php", "?>"), "", $source);
		// Create a temporary file of the source and call php_strip_whitespace to get the minified source
		$source	= "<?php" . $source . "?>";
		$tmp	= tempnam(sys_get_temp_dir(), "CssMin");
		if (file_put_contents($tmp, $source) === false)
			{
			return false;
			}
		$source = php_strip_whitespace($tmp);
		unlink($tmp);
		// Add the main comment and save the file
		$source = str_replace("<?php", "<?php\n" . $comment, $source);
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
	 * @return boolean TRUE if the class was found and loaded; FALSE is the class was not found
	 */
	public static function autoload($class)
		{
		static $index = null;
		// Create the class index for autoloading
		if (is_null($index))
			{
			$index = array();
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
					$index[$class] = $file;
					}
				}
			}
		if (isset($index[$class]))
			{
			require($index[$class]);
			return true;
			}
		return false;
		}
	/**
	 * Initialises CssMin.
	 * 
	 * @return void
	 */
	public static function initialise()
		{
		spl_autoload_register(array(__CLASS__, "autoload"));
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
	 * @return array Array of aCssToken
	 */
	public static function parse($source)
		{
		$parser = new CssParser($source);
		return $parser->getTokens();
		}
	}
// Initialises CssMin
CssMin::initialise();
?>