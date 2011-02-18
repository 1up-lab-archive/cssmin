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
 * This {@link aCssMinifierFilter minifier filter} sets the IsLast property of any last declaration in a ruleset, 
 * @font-face at-rule or @page at-rule block. If the property IsLast is TRUE the decrations will get stringified 
 * without tailing semicolon.
 * --
 * 
 * @package		CssMin/Minifier/Filters
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssRemoveLastDelarationSemiColonMinifierFilter extends aCssMinifierFilter
	{
	/**
	 * Implements {@link aCssMinifierFilter::filter()}.
	 * 
	 * @param array $tokens Array of objects of type aCssToken
	 * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
	 */
	public function apply(array &$tokens)
		{
		for ($i = 0, $l = count($tokens); $i < $l; $i++)
			{
			$current	= get_class($tokens[$i]);
			$next		= isset($tokens[$i+1]) ? get_class($tokens[$i+1]) : false;
			if (($current === "CssRulesetDeclarationToken" && $next === "CssRulesetEndToken") ||
				($current === "CssAtFontFaceDeclarationToken" && $next === "CssAtFontFaceEndToken") || 
				($current === "CssAtPageDeclarationToken" && $next === "CssAtPageEndToken"))
				{
				$tokens[$i]->IsLast = true;
				}
			}
		return 0;
		}
	}
?>