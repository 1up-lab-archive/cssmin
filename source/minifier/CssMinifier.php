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
class CssMinifier
	{
	/**
	 * Configuration.
	 * 
	 * @var array
	 */
	private $config = array();
	/**
	 * Default configuration.
	 * 
	 * @var array
	 */
	private $defaults = array
		(
		"filters" => "RemoveComments, RemoveEmptyRulesets, RemoveEmptyAtBlocks, ConvertLevel3Properties, RemoveLastDelarationSemiColon, Variables",
		"plugins" => "Variables, ConvertFontWeight, ConvertHslColors, ConvertRgbColors, ConvertNamedColors, CompressColorValues, CompressUnitValues"
		);
	/**
	 * {@link aCssMinifierFilter Filters}.
	 *  
	 * @var array
	 */
	private $filters = array();
	/**
	 * {@link aCssMinifierPlugin Plugins}.
	 * 
	 * @var array
	 */
	private $plugins = array();
	/**
	 * Minified source.
	 * 
	 * @var string
	 */
	private $minified = "";
	/**
	 * Constructer.
	 * 
	 * Creates instances of the used {@link aCssMinifierFilter filters} and {@link aCssMinifierPlugin plugins}.
	 * 
	 * @param string $source CSS source
	 * @param array $config Configuration [optional]
	 * @return void
	 */
	public function __construct($source = null, array $config = array())
		{
		$this->config = $config;
		$filters = array_values(array_filter(array_map("trim", explode(",", (isset($config["filters"]) ? $config["filters"] : $this->defaults["filters"])))));
		$plugins = array_values(array_filter(array_map("trim", explode(",", (isset($config["plugins"]) ? $config["plugins"] : $this->defaults["plugins"])))));
		// Filters
		foreach ($filters as $i => $filter)
			{
			$class = "Css" . $filter . "MinifierFilter";
			if (class_exists($class))
				{
				$this->filters[$i] = new $class($this);
				}
			else
				{
				new CssError("The filter <code>" . $filter . "</code> with the class name <code>" . $class . "</code> was not found");
				}
			}
		// Plugins
		foreach ($plugins as $i => $plugin)
			{
			$class = "Css" . $plugin . "MinifierPlugin";
			if (class_exists($class))
				{
				$this->plugins[$i] = new $class($this);
				}
			else
				{
				new CssError("The plugin <code>" . $plugin . "</code> with the class name <code>" . $class . "</code> was not found");
				}
			}
		if (!is_null($source))
			{
			$this->minify($source);
			}
		}
	/**
	 * Returns the minified Source.
	 * 
	 * @return string
	 */
	public function getMinified()
		{
		return $this->minified;
		}
	/**
	 * Returns a plugin by class name.
	 * 
	 * @param string $name Class name of the plugin
	 * @return aCssMinifierPlugin
	 */
	public function getPlugin($class)
		{
		static $index = null;
		if (is_null($index))
			{
			$index = array();
			for ($i = 0, $l = count($this->plugins); $i < $l; $i++)
				{
				$index[get_class($this->plugins[$i])] = $i;
				}
			}
		return isset($index[$class]) ? $this->plugins[$index[$class]] : false;
		}
	/**
	 * Minifies the CSS source.
	 * 
	 * @param string $source CSS source
	 * @return string
	 */
	public function minify($source)
		{
		// Variables
		$r				= "";
		$parser			= new CssParser($source);
		##StopWatch::tick("MINIFIER: Start");
		$tokens			= $parser->getTokens();
		$filters 		= $this->filters;
		$filterCount	= count($this->filters);
		$plugins		= $this->plugins;
		$pluginCount	= count($this->plugins);
		// Apply filters
		for($i = 0; $i < $filterCount; $i++)
			{
			// Apply the filter; if the return value is larger than 0...
			if ($filters[$i]->apply($tokens) > 0)
				{
				// ...then filter null values and rebuild the token array
				$tokens = array_values(array_filter($tokens));
				}
			}
		$tokenCount		= count($tokens);
		// Apply plugins to the tokens
		for($i = 0; $i < $tokenCount; $i++)
			{
			for($ii = 0; $ii < $pluginCount; $ii++)
				{
				// Apply the plugin; if the return value is TRUE continue to the next token
				if ($plugins[$ii]->apply($tokens[$i]) === true)
					{
					continue;
					}
				}
			}
		// Stringify the tokens
		for($i = 0; $i < $tokenCount; $i++)
			{
			$r .= (string) $tokens[$i];
			}
		$this->minified = $r;
		##dump(StopWatch::end("MINIFIER: End"));die;
		return $r;
		}
	}
?>