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
 * @package		CssMin/Formatter
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
abstract class aCssFormatter
	{
	protected $ident = "    ";
	protected $padding = 0;
	/**
	 * --
	 * 
	 * @var array
	 */
	protected $tokens = array();
	/**
	 * --
	 * 
	 * @param array $tokens
	 * @return void
	 */
	public function __construct(array $tokens, $indent = null, $padding = null)
		{
		$this->tokens	= $tokens;
		$this->indent	= !is_null($indent) ? $indent : "    ";
		$this->padding	= !is_null($padding) ? $padding : 0;
		}
	/**
	 * --
	 * 
	 * @return string
	 */
	abstract public function __toString();
	}
?>