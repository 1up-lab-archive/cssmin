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
 * Abstract definition of a parser plugin class. Parser plugin contains the logic for parsing adn creating one or more 
 * tokens.
 * 
 * --
 * 
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
abstract class aCssParserPlugin
	{
	/**
	 * String of chars triggering this plugin.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = false;
	/**
	 * Comma seperated string of states triggering this plugin or FALSE if all states triggering this plugin.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = false;
	/**
	 * The CssParser of the plugin.
	 * 
	 * @var CssParser
	 */
	protected $parser = null;
	/**
	 * Plugin buffer.
	 * 
	 * @var string
	 */
	protected $buffer = "";
	/**
	 * Constructor.
	 * 
	 * @param CssParser $parser The CssParser object of this plugin.
	 * @return void
	 */
	public function __construct(CssParser $parser)
		{
		$this->parser = $parser;
		}
	/**
	 * Parser routine of the plugin.
	 * 
	 * @param integer $index Current index of the CssParser
	 * @param string $char Current char
	 * @param string $previousChar Previous char
	 * @return boolean
	 */
	abstract public function parse($index, $char, $previousChar, $state);
	}
?>