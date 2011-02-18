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
 * This {@link aCssMinifierPlugin} compress the content of expresssion() declaration values using 
 * {@link https://github.com/rgrove/jsmin-php/ JSMin}. JSMin have to be already included or loadable via 
 * {@link http://goo.gl/JrW54 PHP autoloading}. 
 * --
 * 
 * @package		CssMin/Minifier/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssCompressExpressionValuesMinifierPlugin extends aCssMinifierPlugin
	{
	/**
	 * Implements {@link aCssMinifierPlugin::minify()}.
	 * 
	 * @param aCssToken $token Token to process
	 * @return boolean Return TRUE to break the processing of this token; FALSE to continue
	 */
	public function apply(aCssToken &$token)
		{
		if (class_exists("JSMin") && get_class($token) === "CssRulesetDeclarationToken" && stripos($token->Value, "expression(") !== false)
			{
			$value	= $token->Value;
			$value	= substr($token->Value, stripos($token->Value, "expression(") + 10);
			$value	= trim(JSMin::minify($value));
			$token->Value = $value;
			}
		return false;
		}
	}
?>