<?php
/**
 * CssMin - A (simple) css minifier with benefits
 * 
 * --
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING 
 * BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND 
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, 
 * DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
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
	 * Index for unsed by the {@link CssMin::autoload()} method.
	 * 
	 * @var array
	 */
	private static $autoload = array();
	/**
	 * Create a build version of CssMin.
	 * 
	 * The php source get minifed by using the php function {@link http://goo.gl/eIcoH php_strip_whitespace()}.
	 * 
	 * @param string $to
	 * @return string
	 */
	public static function build($target)
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
		if (file_put_contents($target, $source) === false)
			{
			return false;
			}
		return $source;
		}
	/**
	 * @link http://goo.gl/JrW54 Autoload} function of CssMin.
	 * 
	 * @param string $class Name of the class
	 * @return boolean 
	 */
	public static function autoload($class)
		{
		if (isset(self::$autoload[$class]))
			{
			require(self::$autoload[$class]);
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
		// Create the class index for autoloading
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
				self::$autoload[$class] = $file;
				}
			}
		spl_autoload_register(array(__CLASS__, "autoload"));
		}
	/**
	 * Minifies css source.
	 * 
	 * @param string $source Css source
	 * @return string Minified css
	 */
	public static function minify($source)
		{
		$minifier = new CssMinifier($source);
		return $minifier->getMinified();
		}
	}
CssMin::initialise();
?>