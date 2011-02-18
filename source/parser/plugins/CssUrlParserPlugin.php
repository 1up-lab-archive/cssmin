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
 * This {@link aCssParserPlugin parser plugin} is responsible for parsing url string. This plugin only makes sure url
 * strings get parsed properly and will return no token.
 * --
 * 
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssUrlParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = "()";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = false;
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
		// Start of string
		if ($char === "(" && strtolower(substr($this->parser->getSource(), $index - 3, 4)) === "url(" && $state !== "T_URL")
			{
			$this->parser->pushState("T_URL");
			$this->parser->setExclusive(__CLASS__);
			}
		// Escaped LF in url => remove escape backslash and LF
		elseif ($char === "\n" && $previousChar === "\\" && $state === "T_URL")
			{
			$this->parser->setBuffer(substr($this->parser->getBuffer(), 0, -2));
			}
		// Parse error: Unescaped LF in string literal
		elseif ($char === "\n" && $previousChar !== "\\" && $state === "T_URL")
			{
			$line = $this->parser->getBuffer();
			$this->parser->setBuffer(substr($this->parser->getBuffer(), 0, -1) . ")"); // Replace the LF with the url string delimiter
			$this->parser->popState();
			$this->parser->unsetExclusive();
			new CssError("Unterminated string literal", $line . "_");
			}
		// End of string
		elseif ($char === ")" && $state === "T_URL")
			{
			$this->parser->popState();
			$this->parser->unsetExclusive();
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>