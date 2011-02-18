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
 * Abstract definition of a minifier filter class. Minifier filters allows a pre-processing of the parsed token to
 * add, edit or delete tokens.
 * --
 * 
 * @package		CssMin/Minifier/Filters
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
abstract class aCssMinifierFilter
	{
	/**
	 * The CssMinifier of the plugin.
	 * 
	 * @var CssMinifier
	 */
	protected $minifier = null;
	/**
	 * Constructor.
	 * 
	 * @param CssMinifier $minifier The CssMinifier object of this plugin.
	 * @return void
	 */
	public function __construct(CssMinifier $minifier)
		{
		$this->minifier = $minifier;
		}
	/**
	 * Filter the tokens.
	 * 
	 * @param array $tokens Array of objects of type aCssToken
	 * @return integer Count of added, changed or removed tokens; a return value large than 0 will rebuild the array
	 */
	abstract public function apply(array &$tokens);
	}
?>