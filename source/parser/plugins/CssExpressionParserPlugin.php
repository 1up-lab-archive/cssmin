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
 * This {@link aCssParserPlugin parser plugin} handles expression() declaration values. 
 * --
 * 
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssExpressionParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = "();}";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = false;
	
	private $leftBraces = 0;
	private $rightBraces = 0;
	/**
	 * Implements {@link aCssParserPlugin::parse()}.
	 * 
	 * @param integer $index Current index
	 * @param string $char Current char
	 * @param string $previousChar Previous char
	 * @return mixed TRUE will break the processing; FALSE continue with the next plugin; integer set a new index and break the processing
	 */
	public function parse($index, $char, $previousChar, $state)
		{
		// Start of expression
		if ($char === "(" && strtolower(substr($this->parser->getSource(), $index - 10, 11)) === "expression(" && $state !== "T_EXPRESSION")
			{
			$this->parser->pushState("T_EXPRESSION");
			$this->leftBraces++;
			}
		// Count left braces
		elseif ($char === "(" && $state === "T_EXPRESSION")
			{
			$this->leftBraces++;
			}
		// Count right braces
		elseif ($char === ")" && $state === "T_EXPRESSION")
			{
			$this->rightBraces++;
			}
		// Possible end of expression
		elseif (($char === ";" || $char === "}") && $state === "T_EXPRESSION" && $this->leftBraces === $this->rightBraces)
			{
			// If left and right braces are equal the expressen ends
			if ($this->leftBraces === $this->rightBraces)
				{
				$this->leftBraces = $this->rightBraces = 0;
				$this->parser->popState();
				return $index - 1;
				}
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>