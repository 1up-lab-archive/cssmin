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
 * This {@link aCssParserPlugin parser plugin} is responsible for parsing rulesets and the containing declarations. It 
 * returns the {@link CssRulesetStartToken}, {@link CssRulesetDeclarationToken} and {@link CssRulesetEndToken} tokens.
 * --
 *
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssRulesetParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = ",{}:;";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = "T_DOCUMENT,T_AT_MEDIA,T_RULESET::SELECTORS,T_RULESET,T_RULESET_DECLARATION";
	/**
	 * Selectors.
	 * 
	 * @var array
	 */
	private $selectors = array();
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
		// Start of Ruleset and selectors
		if ($char === "," && ($state === "T_DOCUMENT" || $state === "T_AT_MEDIA" || $state === "T_RULESET::SELECTORS"))
			{
			if ($state != "T_RULESET::SELECTORS")
				{
				$this->parser->pushState("T_RULESET::SELECTORS");
				}
			$this->selectors[] = $this->parser->getAndClearBuffer(",{");
			}
		// End of selectors and start of declarations
		elseif ($char === "{" && ($state === "T_DOCUMENT" || $state === "T_AT_MEDIA" || $state === "T_RULESET::SELECTORS"))
			{
			if ($this->parser->getBuffer() !== "")
				{
				$this->selectors[] = $this->parser->getAndClearBuffer(",{");
				if ($state == "T_RULESET::SELECTORS")
					{
					$this->parser->popState();
					}
				$this->parser->pushState("T_RULESET");
				$this->parser->appendToken(new CssRulesetStartToken($this->selectors));
				$this->selectors = array();
				}
			}
		// Start of declaration
		elseif ($char === ":" && $state === "T_RULESET")
			{
			$this->parser->pushState("T_RULESET_DECLARATION");
			$this->buffer = $this->parser->getAndClearBuffer(":;", true);
			}
		// Unterminated ruleset declaration
		elseif ($char === ":" && $state === "T_RULESET_DECLARATION")
			{
			// Ignore Internet Explorer filter declarations
			if ($this->buffer === "filter")
				{
				return false;
				}
			trigger_error(new CssError("Unterminated declaration", $this->buffer . ":" . $this->parser->getBuffer() . "_"), E_USER_WARNING);
			}
		// End of declaration
		elseif (($char === ";" || $char === "}") && $state === "T_RULESET_DECLARATION")
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
			$this->parser->appendToken(new CssRulesetDeclarationToken($this->buffer, $value, $this->parser->getMediaTypes(), $isImportant));
			// Declaration ends with a right curly brace; so we have to end the ruleset
			if ($char === "}")
				{
				$this->parser->appendToken(new CssRulesetEndToken());
				$this->parser->popState();
				}
			$this->buffer = "";
			}
		// End of ruleset
		elseif ($char === "}" && $state === "T_RULESET")
			{
			$this->parser->popState();
			$this->parser->clearBuffer();
			$this->parser->appendToken(new CssRulesetEndToken());
			$this->buffer = "";
			$this->selectors = array();
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>