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
 * This {@link aCssParserPlugin parser plugin} is responsible for parsing css comments and returns the 
 * {@link CssCommentToken} token.
 * --
 * 
 * @package		CssMin/Parser/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssCommentParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = "\*/";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = false;
	/**
	 * Stored buffer for restore.
	 * 
	 * @var string
	 */
	private $restoreBuffer = "";
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
		if ($char === "*" && $previousChar === "/" && $state !== "T_COMMENT")
			{
			$this->parser->pushState("T_COMMENT");
			$this->parser->setExclusive(__CLASS__);
			$this->restoreBuffer = substr($this->parser->getAndClearBuffer(), 0, -2);
			}
		elseif ($char === "/" && $previousChar === "*" && $state === "T_COMMENT")
			{
			$this->parser->popState();
			$this->parser->unsetExclusive();
			$this->parser->appendToken(new CssCommentToken("/*" . $this->parser->getAndClearBuffer()));
			$this->parser->setBuffer($this->restoreBuffer);
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>