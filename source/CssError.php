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
 * @package		CssMin
 * @link		http://code.google.com/p/cssmin/
 * @author		Joe Scylla <joe.scylla@gmail.com>
 * @copyright	2008 - 2011 Joe Scylla <joe.scylla@gmail.com>
 * @license		http://opensource.org/licenses/mit-license.php MIT License
 * @version		3.0.0
 */
class CssError
	{
	/**
	 * Level: Notice
	 * 
	 * @var integer
	 */
	const NOTICE = E_USER_NOTICE;
	/**
	 * Level: Warning
	 * 
	 * @var integer
	 */
	const ERROR = E_USER_ERROR;
	/**
	 * Level: Error
	 * 
	 * @var integer
	 */
	const WARNING = E_USER_WARNING;
	/**
	 * --
	 * 
	 * @param string $message
	 * @param string $line
	 * @param integer $level
	 */
	public function __construct($message, $line = "undefined", $level = self::WARNING)
		{
		trigger_error($message . ":<p><code>" . $line . "</code></p>", $level);
		}
	}
?>