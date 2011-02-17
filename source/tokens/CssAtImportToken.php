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
 * This {@link aCssToken CSS token} represents a @import at-rule.
 * --
 * 
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssAtImportToken extends aCssToken
	{
	/**
	 * Import path of the @import at-rule.
	 * 
	 * @var string
	 */
	public $Import = "";
	/**
	 * Media types of the @import at-rule.
	 * 
	 * @var array
	 */
	public $MediaTypes = array();
	/**
	 * Set the properties of a @import at-rule token.
	 * 
	 * @param string $import Import path
	 * @param array $mediaTypes Media types
	 * @return void
	 */
	public function __construct($import, $mediaTypes)
		{
		$this->Import		= $import;
		$this->MediaTypes	= $mediaTypes ? $mediaTypes : array();
		}
	/**
	 * Implements {@link aCssToken::__toString()}.
	 * 
	 * @return string
	 */
	public function __toString()
		{
		return "@import " . $this->Import . (count($this->MediaTypes) > 0 ? " "  . implode(",", $this->MediaTypes) : ""). ";";
		}
	}
?>