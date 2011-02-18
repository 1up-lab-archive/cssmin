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
 * This {@link aCssMinifierPlugin} will process var-statement and sets the declaration value to the variable value. 
 * This plugin only apply the variable values. The variable values itself will get parsed by the
 * {@link CssVariablesMinifierFilter}. Example:
 * 
 * <code>
 * @variables
 * 		{
 * 		defaultColor: black;
 * 		}
 * color: var(defaultColor);
 * </code>
 * 
 * Will get converted to:
 * 
 * <code>
 * color:black;
 * </code>
 *
 * @package		CssMin/Minifier/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssVariablesMinifierPlugin extends aCssMinifierPlugin
	{
	/**
	 * Regular expression matching a value.
	 * 
	 * @var string
	 */
	private $reMatch = "/var\((.+)\)/iSU";
	/**
	 * Parsed variables.
	 * 
	 * @var array
	 */
	private $variables = null;
	/**
	 * Returns the variables.
	 * 
	 * @return array
	 */
	public function getVariables()
		{
		return $this->variables;
		}
	/**
	 * Implements {@link aCssMinifierPlugin::minify()}.
	 * 
	 * @param aCssToken $token Token to process
	 * @return boolean Return TRUE to break the processing of this token; FALSE to continue
	 */
	public function apply(aCssToken &$token)
		{
		if (get_class($token) === "CssRulesetDeclarationToken" && stripos($token->Value, "var") !== false && preg_match($this->reMatch, $token->Value, $m))
			{
			$variable = trim($m[1]);
			$mediaTypes = $token->MediaTypes;
			if (!in_array("all", $mediaTypes))
				{
				$mediaTypes[] = "all";
				}
			foreach ($mediaTypes as $mediaType)
				{
				if (isset($this->variables[$mediaType], $this->variables[$mediaType][$variable]))
					{
					// Variable value found => set the declaration value to the variable value and return
					$token->Value = $this->variables[$mediaType][$variable];
					return false;
					}
				}
			// If no variable value was found trigger an error and replace the token with a CssNullToken
			trigger_error(new CssError("No variable value found for variable <code>" . $variable . "</code> in media types <code>" . implode(", ", $mediaTypes) . "</code>", (string) $token), E_USER_WARNING);
			$token = new CssNullToken();
			}
		return false;
		}
	/**
	 * Sets the variables.
	 * 
	 * @param array $variables Variables to set
	 * @return void
	 */
	public function setVariables(array $variables)
		{
		$this->variables = $variables;
		}
	}
?>