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
 * This {@link aCssParserPlugin parser plugin} is responsible for parsing the @import at-rule returns the 
 * {@link CssAtImportToken} token.
 * --
 * 
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssAtImportParserPlugin extends aCssParserPlugin
	{
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_CHARS}.
	 * 
	 * @var string
	 */
	const TRIGGER_CHARS = "@;,\n";
	/**
	 * Implements {@link aCssParserPlugin::TRIGGER_STATES}.
	 * 
	 * @var string
	 */
	const TRIGGER_STATES = "T_DOCUMENT,T_AT_IMPORT";
	/**
	 * Implements {@link aCssParserPlugin::parse()}.
	 * 
	 * @param integer $index Current index of the CssParser
	 * @param string $char Current char
	 * @param string $previousChar Previous char
	 * @return boolean
	 */
	public function parse($index, $char, $previousChar, $state)
		{
		if ($char === "@" && $state === "T_DOCUMENT" && strtolower(substr($this->parser->getSource(), $index, 7)) === "@import")
			{
			$this->parser->pushState("T_AT_IMPORT");
			$this->parser->clearBuffer();
			return $index + 7;
			}
		elseif (($char === ";" || $char === "\n") && $state === "T_AT_IMPORT")
			{
			$this->buffer = $this->parser->getAndClearBuffer(";");
			$pos = false;
			foreach (array(")", "\"", "'") as $needle)
				{
				if (($pos = strrpos($this->buffer, $needle)) !== false)
					{
					break;
					}
				}
			$import = substr($this->buffer, 0, $pos + 1);
			$mediaTypes = array_filter(array_map("trim", explode(",", trim(substr($this->buffer, $pos + 1), " \t\n\r\0\x0B{"))));
			if ($pos)
				{
				$this->parser->appendToken(new CssAtImportToken($import, $mediaTypes));
				}
			else
				{
				new CssError("Invalid @import at-rule syntax", $this->parser->buffer);
				}
			$this->parser->popState();
			}
		else
			{
			return false;
			}
		return true;
		}
	}
?>