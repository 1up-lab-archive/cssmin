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
 * Abstract definition of a minifier plugin class. Minifier plugin process the parsed tokens one by one to apply 
 * changes to the token.
 * --
 *
 * @package		CssMin/Minifier/Plugins
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
abstract class aCssMinifierPlugin
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
	 * Apply the plugin to the token.
	 * 
	 * @param aCssToken $token Token to process
	 * @return boolean Return TRUE to break the processing of this token; FALSE to continue
	 */
	abstract public function apply(aCssToken &$token);
	}
?>