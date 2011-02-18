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
 * This {@link aCssParserPlugin parser plugin} is responsible for parsing the @variables at-rule block and the 
 * containing declarations. It returns the {@link CssAtVariablesStartToken}, {@link CssAtVariablesDeclarationToken} and 
 * {@link CssAtVariablesEndToken} tokens.
 * --
 *
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssAtVariablesParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = "@{}:;";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = "T_DOCUMENT,T_AT_VARIABLES::PREPARE,T_AT_VARIABLES,T_AT_VARIABLES_DECLARATION";
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
		// Start of @variables at-rule block
		if ($char === "@" && $state === "T_DOCUMENT" && strtolower(substr($this->parser->getSource(), $index, 10)) === "@variables")
			{
			$this->parser->pushState("T_AT_VARIABLES::PREPARE");
			$this->parser->clearBuffer();
			return $index + 10;
			}
		// Start of @variables declarations
		elseif ($char === "{" && $state === "T_AT_VARIABLES::PREPARE")
			{
			$this->parser->setState("T_AT_VARIABLES");
			$mediaTypes = array_filter(array_map("trim", explode(",", $this->parser->getAndClearBuffer("{"))));
			$this->parser->appendToken(new CssAtVariablesStartToken($mediaTypes));
			}
		// Start of @variables declaration
		if ($char === ":" && $state === "T_AT_VARIABLES")
			{
			$this->buffer = $this->parser->getAndClearBuffer(":");
			$this->parser->pushState("T_AT_VARIABLES_DECLARATION");
			}
		// Unterminated @variables declaration
		elseif ($char === ":" && $state === "T_AT_VARIABLES_DECLARATION")
			{
			// Ignore Internet Explorer filter declarations
			if ($this->buffer === "filter")
				{
				return false;
				}
			new CssError("Unterminated @variables declaration", $this->buffer . ":" . $this->parser->getBuffer() . "_");
			}
		// End of @variables declaration
		elseif (($char === ";" || $char === "}") && $state === "T_AT_VARIABLES_DECLARATION")
			{
			$value = $this->parser->getAndClearBuffer(";}");
			if (strtolower(substr($value, -10, 10)) === "!important")
				{
				$value = trim(substr($value, 0, -10));
				$isImportant = true;
				}
			else
				{
				$isImportant = false;
				}
			$this->parser->popState();
			$this->parser->appendToken(new CssAtVariablesDeclarationToken($this->buffer, $value, $isImportant));
			$this->buffer = "";
			}
		// End of @variables at-rule block
		elseif ($char === "}" && $state === "T_AT_VARIABLES")
			{
			$this->parser->popState();
			$this->parser->clearBuffer();
			$this->parser->appendToken(new CssAtVariablesEndToken());
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>